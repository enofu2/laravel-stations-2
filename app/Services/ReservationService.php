<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{

    public function __construct()
    {

    }

    public function store(array $request = []) :array
    {
        //レスポンスオブジェクト
        //TODO: そのうちDTO化したいところ
        //  (Serviceクラスのabstruct作るタイミングで実現かな...)
        $response = [
            'isSucced' => false,
            'isDuplicated' => false,
            'data' => null,
        ];
        //uniqueキーですでに予約済みか検索
        $query = Reservation::query()
            ->where('schedule_id',$request['schedule_id'])
            ->where('sheet_id',$request['sheet_id']);

        //すでに予約済みの場合
        if($query->exists()){
            $response['isSucceed'] = false;
            $response['isDuplicated'] = true;
        }else{
            //新規登録
            $data = Reservation::query()->create($request);
            $response['isSucced'] = true;
            $response['isDuplicated'] = false;
            $response['data'] = $data;
        }
        return $response;
    }
}