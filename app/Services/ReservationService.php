<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Properties\Reservation\ReservationProperties;
use App\Transfers\Reservation\ReservationTransfer;
use DateTime;
use Exception;

class ReservationService
{
    /**
     * reservationsの新規登録フォーム表示用のデータを返す
     * 
     */
    public function getFormData($movie_id,$schedule_id,$sheet_id,$date) :ReservationProperties
    {
        $schedule = Schedule::query()->with(['movie'])
            ->where('id',$schedule_id)
            ->first();
        $sheet = Sheet::query()->where('id',$sheet_id)
            ->first();
        
        //dtoのインスタンスを取得
        $dto = ReservationProperties::create();
        //すでに予約済みの場合
        if($this->ReservationExists($schedule_id,$sheet_id)){
            $dto->create_isDuplicated = true;
        }
        //疑似dtoに詰め込む
        $dto->movie_title = $schedule->movie->title;
        $dto->schedule_start_time = $schedule->start_time;
        $dto->schedule_end_time = $schedule->end_time;
        $dto->sheet_row = $sheet->row;
        $dto->sheet_column = $sheet->column;
        //引数から得た情報も詰め込む
        $dto->movie_id = $movie_id;
        $dto->schedule_id = $schedule_id;     
        $dto->sheet_id = $sheet_id;
        //日付はY-m-dに変換する
        $dto->date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('Y-m-d');

        return $dto;
    }

    public function store(ReservationTransfer $trans) :ReservationProperties
    {
        //レスポンスオブジェクト
        //TODO: そのうちDTO化したいところ
        //  (Serviceクラスのabstruct作るタイミングで実現かな...)
        //追記：疑似DTO化しました！
        $dto = ReservationProperties::create();
        $dto->store_isSucced = false;
        $dto->store_isDuplicated = false;

        //movie_idを取得
        $schedule = Schedule::query()->with(['movie'])
        ->where('id',$trans->schedule_id)
        ->first();
        //movie_id格納
        if(isset($schedule->movie->id)) {
        $dto->movie_id = $schedule->movie->id;
        }else{
            throw new Exception("movie_idがない!");
        }

        //すでに予約済みの場合
        if($this->ReservationExists($trans->schedule_id,$trans->sheet_id)){
            $dto->store_isSucced = false;
            $dto->store_isDuplicated = true;
        }else{
            //新規登録
            $data = Reservation::query()->create(
                $trans->store()
            );
            //処理結果をdtoに格納
            $dto->store_isSucced = true;
            $dto->store_isDuplicated = false;
            $dto->store_data = $data;
        }
        //表示用データをdtoに移す
        $dto->schedule_id = $trans->schedule_id;
        $dto->sheet_id = $trans->sheet_id;
        //日付はY-m-d H:i:sに変換する
        $dto->date = DateTime::createFromFormat('Y-m-d',$trans->date)->format('Y-m-d H:i:s');
        return $dto;
    }

    public function ReservationExists($schedule_id,$sheet_id)
    {
        //uniqueキーですでに予約済みか検索
        $query = Reservation::query()
        ->where('schedule_id',$schedule_id)
        ->where('sheet_id',$sheet_id);

        return $query->exists();
    }
}