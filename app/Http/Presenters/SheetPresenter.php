<?php

namespace App\Http\Presenters;

use Illuminate\Support\Facades\Session;

class SheetPresenter
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
     * シートの一覧を返す
     */
    public function sheets($sheets = [],$status = 200)
    {
        return response(
            view('get.sheet.sheets',compact('sheets')),
            $status,
            []);
    }

    /**
     * 予約のためのシート一覧を返す
     */
    public function reservation($sheets = [],$date,$movie_id,$schedule_id,$status = 200)
    {
        return response(
            view('get.sheet.sheets',compact('sheets','date','movie_id','schedule_id')),
            $status,
            []);
    }
}