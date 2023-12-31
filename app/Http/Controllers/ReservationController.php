<?php

namespace App\Http\Controllers;

use App\Http\Presenters\ReservationPresenter;
use App\Http\Requests\Reservation\CreateAdminReservationRequest;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\GetCreateFormForReservationRequest;
use App\Http\Requests\Reservation\UpdateAdminReservationRequest;
use App\Properties\Reservation\ReservationProperties;
use App\Services\ReservationService;
use App\Services\SheetService;
use App\Transfers\Reservation\ReservationTransfer;
use Carbon\Carbon;
use Exception;

class ReservationController extends Controller
{
    private $ReservationService;
    private $ReservationPresenter;
    private $SheetService;

    public function __construct(
        ReservationService $ReservationService,
        ReservationPresenter $ReservationPresenter,
        SheetService $SheetService,
        )
    {
        $this->ReservationService = $ReservationService;
        $this->ReservationPresenter = $ReservationPresenter;
        $this->SheetService = $SheetService;
    }

    /**
     * Reservationの新規登録フォームを返却
     */
    public function create(GetCreateFormForReservationRequest $request,$movie_id,$schedule_id) {
        if($request->isFailed()){
            return $this->ReservationPresenter->error($request->getErrors(),400);
        }
        //クエリパラメータを詰めなおす
        $sheet_id = $request->query('sheetId');
        $date = $request->query('date');

        $dto = $this->ReservationService->getFormData($movie_id,$schedule_id,$sheet_id,$date);
        if($dto->create_isDuplicated){
            $sheetDto = $this->SheetService->getSheetArray();
            return $this->ReservationPresenter->errorWhenDuplicated($dto,$sheetDto,false,400);
        }else{
            return $this->ReservationPresenter->createForm($dto);
        }
    }

    /**
     * Reservationを登録
     */
    public function store(CreateReservationRequest $request) {
        if($request->isFailed()){
            return $this->ReservationPresenter->errorRedirect($request->getErrors());
        }
        //リクエストデータをtrasnferに詰めなおす
        $trans = ReservationTransfer::create();
        $trans->date = $request['date'] ?? Carbon::now();
        $trans->schedule_id = $request['schedule_id'];
        $trans->sheet_id = $request['sheet_id'];
        $trans->email = $request['email'];
        $trans->name = $request['name'];
        $trans->is_canceled = false;

        try {
            $storeResponse = $this->ReservationService->store($trans);
        }catch(Exception $e){
            $exceptionErrors = [
                'msg' => "例外が発生しました",
                "exception" => $e->getMessage()
            ];
            return $this->ReservationPresenter->error($exceptionErrors,400);
        }

        if($storeResponse->store_isSucced == false) {
            if ($storeResponse->store_isDuplicated){        
                $dto = ReservationProperties::create();
                $dto->movie_id = $storeResponse->movie_id;
                $dto->schedule_id = $storeResponse->schedule_id;
                $dto->date = $storeResponse->date;
                $SheetDto = $this->SheetService->getSheetArray();
                return $this->ReservationPresenter->errorWhenDuplicated($dto,$SheetDto,true,302);
            }else{
                $unknownErrorMsg = ['msg' => 'エラーが発生しました'];
                return $this->ReservationPresenter->error($unknownErrorMsg,400);  
            }
        }

        return $this->ReservationPresenter->succeedStore($storeResponse->movie_id);
    }

    //
    //############以下、管理者用###########
    //

    /**
     * 管理者用の予約一覧を返却
     */
    public function adminReservations(){
        $dto = $this->ReservationService->getReservations();
        return $this->ReservationPresenter->reservations($dto);
    }
    /**
     * 管理者用の予約の新規登録フォームを返却
     */
    public function adminCreate(){
        $dto = ReservationProperties::create();
        return $this->ReservationPresenter->adminCreateForm($dto);
    }
    /**
     * 管理者用の予約の編集フォームを返却
     */
    public function adminEdit($id){
        $dto = $this->ReservationService->getReservationById($id);
        if($dto->get_isSucced == false) {
            $errorMsg = ['msg' => '該当idの情報が見つかりませんでした'];
            return $this->ReservationPresenter->error($errorMsg,404); 
        }
        return $this->ReservationPresenter->adminEditForm($dto);
    }

    /**
     * 管理者用、Reservationを新規登録
     */
    public function adminStore(CreateAdminReservationRequest $request){
        if($request->isFailed()){
            return $this->ReservationPresenter->errorRedirect($request->getErrors());
        }
        //リクエストデータをtrasnferに詰めなおす
        $trans = ReservationTransfer::create();
        $trans->date = $request['date'] ?? Carbon::now()->format('Y-m-d');
        $trans->schedule_id = $request['schedule_id'];
        $trans->sheet_id = $request['sheet_id'];
        $trans->email = $request['email'];
        $trans->name = $request['name'];
        $trans->is_canceled = false;
        try {
            $storeResponse = $this->ReservationService->store($trans);
        }catch(Exception $e){
            $exceptionErrors = [
                'msg' => "例外が発生しました",
                "exception" => $e->getMessage()
            ];
            return $this->ReservationPresenter->errorWhenAdmin($exceptionErrors);
        }
        if(! $storeResponse->store_isSucced){
            if ($storeResponse->store_isDuplicated){
                //登録済みならエラー        
                $dto = $this->ReservationService->getReservations();
                return $this->ReservationPresenter->errorAdminWhenDuplicated($dto,true,302);
            }else{
                $errorMsg = ['msg' => 'エラーが発生しました'];
                return $this->ReservationPresenter->errorWhenAdmin($errorMsg);
            }
        }
        return $this->ReservationPresenter->succeedAdminStore($storeResponse->id);
    }

    /**
     * 管理者用、Reservationを更新
     */
    public function adminUpdate(UpdateAdminReservationRequest $request,$id){
        if($request->isFailed()){
            return $this->ReservationPresenter->errorRedirect($request->getErrors());
        }

        //sheet_id、schedule_idの組み合わせがすでに登録済みかどうか
        $recordDto = $this->ReservationService->getReservationById($id);
        if($recordDto->schedule_id != $request['schedule_id'] || $recordDto->sheet_id != $request['sheet_id']){
            $isExists = $this->ReservationService
                ->ReservationExists($request['schedule_id'],$request['sheet_id']);
            if($isExists){
                //登録済みならエラー
                $dto = $this->ReservationService->getReservations();
                return $this->ReservationPresenter->errorAdminWhenDuplicated($dto,true,302);
            }
        }

        //リクエストデータをtrasnferに詰めなおす
        $trans = ReservationTransfer::create();
        $trans->id = $id;
        $trans->date = $request['date'] ?? Carbon::now()->format('Y-m-d');
        $trans->schedule_id = $request['schedule_id'];
        $trans->sheet_id = $request['sheet_id'];
        $trans->email = $request['email'];
        $trans->name = $request['name'];
        $trans->is_canceled = false;
        // try {
            $updateResponse = $this->ReservationService->update($trans);
        // }catch(Exception $e){
        //     $exceptionErrors = [
        //         'msg' => "例外が発生しました",
        //         "exception" => $e->getMessage()
        //     ];
        //     return $this->ReservationPresenter->errorWhenAdmin($exceptionErrors);
        // }
        if(! $updateResponse->update_isSucced){
            $errorMsg = ['msg' => 'エラーが発生しました'];
            return $this->ReservationPresenter->errorWhenAdmin($errorMsg);
        }
        return $this->ReservationPresenter->succeedAdminUpdate($updateResponse->id);
    }

    /**
     * 管理者用、Reservationを削除
     */
    public function adminDelete($id){
        try {
            $deleteResponse = $this->ReservationService->delete($id);
        }catch(Exception $e){
            $exceptionErrors = [
                'msg' => "例外が発生しました",
                "exception" => $e->getMessage()
            ];
            return $this->ReservationPresenter->errorWhenAdmin($exceptionErrors);
        }
        if(! $deleteResponse->delete_isSucced){
            if(! $deleteResponse->delete_isFound){
                $dto = $this->ReservationService->getReservations();
                $dto->id = $id;
                return $this->ReservationPresenter->failedAdminDelete($dto);
            }
            $dto = $this->ReservationService->getReservations();
            return $this->ReservationPresenter->failedAdminDelete($$dto);
        }
        return $this->ReservationPresenter->succeedAdminDelete($deleteResponse->id);
    }

}
