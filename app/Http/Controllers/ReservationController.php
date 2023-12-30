<?php

namespace App\Http\Controllers;

use App\Http\Presenters\ReservationPresenter;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Services\ReservationService;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private  $ReservationService;
    private $ReservationPresenter;

    public function __construct(
        ReservationService $ReservationService,
        ReservationPresenter $ReservationPresenter
        )
    {
        $this->ReservationService = $ReservationService;
        $this->ReservationPresenter = $ReservationPresenter;
    }

    /**
     * Reservationの新規登録フォームを返却
     */
    public function create(Request $request,$movie_id,$schedule_id) {
        //クエリパラメータを詰めなおす
        $sheet_id = $request->query('sheetId');
        $date = $request->query('date');

        $dto = $this->ReservationService->getFormData($movie_id,$schedule_id,$sheet_id,$date);
        return $this->ReservationPresenter->createForm($dto);
    }

    /**
     * Reservationを登録
     */
    public function store(CreateReservationRequest $request) {
        if($request->isFailed()){
            return $this->ReservationPresenter->errorRedirect($request->getErrors());
        }

        $passedRequest = $request->validated();
        try {
            $storeResponse = $this->ReservationService->store($passedRequest);
        }catch(Exception $e){
            $exceptionErrors = [
                'msg' => "例外が発生しました",
                "exception" => $e->getMessage()
            ];
            return $this->ReservationPresenter->error($exceptionErrors,500);
        }

        if($storeResponse->store_isSucced == false) {
            if ($storeResponse->store_isDuplicated){
                return $this->ReservationPresenter->errorDuplicatedWhenStore($passedRequest,200);
            }else{
                $unknownErrorMsg = ['msg' => 'エラーが発生しました'];
                return $this->ReservationPresenter->error($unknownErrorMsg,500);  
            }
        }

        return $this->ReservationPresenter->succeedStore($request['movie_id']);
    }
}
