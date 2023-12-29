<?php

namespace App\Http\Presenters;

use Illuminate\Support\Facades\Session;

class ReservationPresenter
{
    /**
     * エラー時のレスポンス
     */
    public function error($errors = [],$status = 422) {
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
    public function createForm(
        $record = [
            'movie_id' => '',
            'movie' => '',
            'schedule_id' => '',
            'schedule' => '',
            'sheet_id' => '',
            'sheet' => '',
            'date' => '',
        ],$status = 200)
    {
        return response(
            view('get.reservation.create',['record' => $record]),
            $status,
            []);
    }
}