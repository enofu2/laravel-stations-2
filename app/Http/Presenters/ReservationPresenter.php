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
     * adminでのエラー時のリダイレクト
     */
    public function errorWhenAdmin($messages = []) {
        $bag = new MessageBag($messages);
        $errbag = new ViewErrorBag;
        $errbag->put('default',$bag);
        Session::flash('errors',$errbag);
        return redirect()->route('admin.reservations.reservations');
    }

    /**
     * store時に座席がすでに予約済みだった場合のレスポンス
     */
    public function errorWhenDuplicated(ReservationProperties $dto,SheetProperties $sheetDto,$redirect = false,$status = 200){
        //Sheet用のdtoに詰めなおす
        $sheetDto->movie_id = $dto->movie_id;
        $sheetDto->schedule_id = $dto->schedule_id;
        $sheetDto->date = $dto->date;
        // $sheetDto->sheets = $sheetDto->sheets;
        Session::flash('warning',['msg' => 'その座席はすでに予約済みです']);
        // return response(
        //         view('app.sheet.sheets',['record' => $sheetDto ]),
        //         $status,
        //         []);
        $movie_id = $sheetDto->movie_id;
        $schedule_id = $sheetDto->schedule_id;
        $date = $sheetDto->date;
        // dd($movie_id,$schedule_id,$date,$sheetDto);
        //リダイレクト、レスポンスのどちらかを選べる
        if($redirect){
            return redirect()->route('sheets.detail',[
                'movie_id' => $movie_id,
                'schedule_id' => $schedule_id,
                'date' => $date,
            ]);
        }else{
            return response(view('app.sheet.sheets',['dto' => $sheetDto]),$status);
        }
    }

    /**
     * 管理者用、store時に座席がすでに予約済みだった場合のリダイレクト
     */
    public function errorAdminWhenDuplicated(ReservationProperties $dto,$redirect = false,$status = 200){
        Session::flash('warning',['msg' => 'その座席はすでに予約済みです']);
        //リダイレクト、レスポンスのどちらかを選べる
        if($redirect){
            return redirect()->route('admin.reservations.reservations',['dto' => $dto]);
        }else{
            return response(view('app.admin.reservation.reservations',['dto' => $dto]),$status);
        }
    }

    /**
     * store成功時のリダイレクト
     */
    public function succeedStore($movie_id) {
        Session::flash('success',['msg' => '予約が完了しました']);
        return redirect()->route('movies\.detail',['id' => $movie_id]);
    }

    /**
     * 管理者、store成功時のリダイレクト
     */
    public function succeedAdminStore($reservation_id) {
        Session::flash('success',['msg' => "[id:$reservation_id]の予約を新規登録しました"]);
        return redirect()->route('admin.reservations.reservations');
    }
    
    /**
     * 管理者、update成功時のリダイレクト
     */
    public function succeedAdminUpdate($reservation_id) {
        Session::flash('success',['msg' => "[id:$reservation_id]の予約を更新しました"]);
        return redirect()->route('admin.reservations.reservations');
    }

        /**
     * 管理者、delete成功時のリダイレクト
     */
    public function succeedAdminDelete($reservation_id) {
        Session::flash('success',['msg' => "[id:$reservation_id]の予約を削除しました"]);
        return redirect()->route('admin.reservations.reservations');
    }
    
    /**
     * 管理者、delete失敗時のレスポンス
     */
    public function failedAdminDelete(ReservationProperties $dto,$status = 404) {
        Session::flash('success',['msg' => "予約の削除に失敗しました"]);
        return response(
            view('app.admin.reservation.reservations',['dto' => $dto]),
            $status,
            []);
    }

    /**
     * reservationsの新規登録フォームを返す
     */
    public function createForm(ReservationProperties $dto,$status = 200)
    {
        return response(
            view('app.reservation.create',['dto' => $dto]),
            $status,
            []);
    }

    /**
     * 管理者用の予約一覧を返す
     */
    public function reservations(ReservationProperties $dto,$status = 200)
    {
        return response(
            view('app.admin.reservation.reservations',['dto' => $dto]),
            $status,
            []);
    }

    /**
     * 管理者用の予約新規登録フォームを返す
     */
    public function adminCreateForm(ReservationProperties $dto,$status = 200)
    {
        return response(
            view('app.admin.reservation.create',['dto' => $dto]),
            $status,
            []);
    }

    /**
     * 管理者用の予約編集フォームを返す
     */
    public function adminEditForm(ReservationProperties $dto,$status = 200)
    {
        return response(
            view('app.admin.reservation.edit',['dto' => $dto]),
            $status,
            []);
    }



}