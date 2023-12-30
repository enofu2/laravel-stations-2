<?php

namespace App\Http\Presenters;

use App\Properties\Sheet\SheetProperties;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class SheetPresenter
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
     * シートの一覧を返す
     */
    public function sheets(SheetProperties $dto,$status = 200)
    {
        return response(
            view('get.sheet.sheets',['dto' => $dto]),
            $status,
            []);
    }

    /**
     * 予約のためのシート一覧を返す
     */
    public function reservation(SheetProperties $dto,$status = 200)
    {
        return response(
            view('get.sheet.sheets',['dto' => $dto]),
            $status,
            []);
    }
}