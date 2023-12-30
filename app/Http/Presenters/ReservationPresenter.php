<?php

namespace App\Http\Presenters;

use App\Properties\Reservation\ReservationProperties;
use App\Properties\Sheet\SheetProperties;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ReservationPresenter
{
    /**
     * エラー時のレスポンス
     */
    public function error($messages = [],$status = 422) {
        $bag = new MessageBag($messages);
        $errbag = new ViewErrorBag;
        $errbag->put('default',$bag);
        Session::flash('errors',$errbag);
        return response(view('error.error'),$status,[]);
    }
    /**
     * エラー時のリダイレクト
     */
    public function errorRedirect($messages = []){
        $bag = new MessageBag($messages);
        $errbag = new ViewErrorBag;
        $errbag->put('default',$bag);
        Session::flash('errors',$errbag);
        return redirect()->back();
    }

    /**
     * store時に座席がすでに予約済みだった場合のレスポンス
     */
    public function errorDuplicatedWhenStore(ReservationProperties $dto,SheetProperties $sheetDto,$status = 200){
        //Sheet用のdtoに詰めなおす
        $sheetDto->movie_id = $dto->movie_id;
        $sheetDto->schedule_id = $dto->schedule_id;
        $sheetDto->date = $dto->date;
        // $sheetDto->sheets = $sheetDto->sheets;
        Session::flash('warning',['msg' => 'その座席はすでに予約済みです']);
        // return response(
        //         view('get.sheet.sheets',['record' => $sheetDto ]),
        //         $status,
        //         []);
        $movie_id = $sheetDto->movie_id;
        $schedule_id = $sheetDto->schedule_id;
        $date = $sheetDto->date;
        return redirect()->route('sheets.detail',compact('movie_id','schedule_id','date'));
    }

    /**
     * store成功時のリダイレクト
     */
    public function succeedStore($movie_id) {
        Session::flash('success',['msg' => '予約が完了しました']);
        return redirect()->route('movie.detail',['id' => $movie_id]);
    }

    /**
     * reservationsの新規登録フォームを返す
     */
    public function createForm(ReservationProperties $dto,$status = 200)
    {
        return response(
            view('get.reservation.create',['dto' => $dto]),
            $status,
            []);
    }
}