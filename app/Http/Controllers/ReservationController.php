<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Presenter\ReservationPresenter;
use App\Services\ReservationService;
use Exception;
use Illuminate\Support\Facades\Request;

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
        $sheet_id = $request->query('sheet_id');
        $date = $request->query('date');
        return $this->ReservationPresenter
            ->createForm($movie_id,$schedule_id,$sheet_id,$date);
    }

    /**
     * Reservationを登録
     */
    public function store(CreateReservationRequest $request) {
        if($request->isFailed()){
            return $this->ReservationPresenter
                ->errorRedirect($request->getErrors());
        }

        $passedRequest = $request->validated();
        try {
            $storeResponse = $this->ReservationService
                ->store($passedRequest);
        }catch(Exception $e){
            $exceptionErrors = [
                'msg' => "例外が発生しました",
                "exception" => $e->getMessage()
            ];
            return $this->ReservationPresenter
                ->error($exceptionErrors,500);
        }

        if($storeResponse['isSucceed'] == false) {
            if ($storeResponse['isDuplicated']){
                return $this->ReservationPresenter
                    ->errorDuplicatedWhenStore($passedRequest,200);
            }else{
                $unknownErrorMsg = ['msg' => 'エラーが発生しました'];
                return $this->ReservationPresenter
                    ->error($unknownErrorMsg,500);  
            }
        }

        return $this->ReservationPresenter
            ->succeedStore($request['movie_id']);
    }
}
