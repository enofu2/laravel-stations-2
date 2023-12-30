<?php

namespace App\Http\Presenters;

use App\Properties\Reservation\ReservationProperties;
use Illuminate\Support\Facades\Session;

class ReservationPresenter
{
    /**
     * エラー時のレスポンス
     */
    public function error($errors = [],$status = 400) {
        Session::flash('error',$errors);
        return response(view('error.error'),$status,[]);
    }
    /**
     * エラー時のリダイレクト
     */
    public function errorRedirect($errors = []){
        Session::flash('error',$errors);
        return redirect()->back();
    }

    /**
     * store時に座席がすでに予約済みだった場合のレスポンス
     */
    public function errorDuplicatedWhenStore($record,$status = 200){
        $movie_id = $record['movie_id'];
        $schedule_id = $record['schedule_id'];
        $date = $record['date'];
        Session::flash('warning',['msg' => 'その座席はすでに予約済みです']);
        return response(
                view('get.sheet.sheets',compact('movie_id','schedule_id','date')),
                $status,
                []);
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
        // //疑似dtoからview用のarrayに詰めなおす
        // $record = [
        //     'movie_title' => $dto->movie_title,
        //     'movie_id' => $dto->movie_id,
        //     'schedule_id' => $dto->schedule_id,
        //     'sheet_row' => $dto->sheet_row,
        //     'sheet_column' => $dto->sheet_column,
        //     'sheet_id' => $dto->sheet_id,
        //     'date' => $dto->date,
        // ];
        return response(
            view('get.reservation.create',['record' => $dto]),
            $status,
            []);
    }
}