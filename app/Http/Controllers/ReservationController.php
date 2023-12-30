<?php

namespace App\Http\Controllers;

use App\Http\Presenters\ReservationPresenter;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\GetCreateFormForReservationRequest;
use App\Properties\Reservation\ReservationProperties;
use App\Services\ReservationService;
use App\Services\SheetService;
use App\Transfers\Reservation\ReservationTransfer;
use Exception;
use Illuminate\Http\Request;

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
        $trans->date = $request['date'];
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
}
