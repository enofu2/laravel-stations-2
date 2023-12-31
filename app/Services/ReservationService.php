<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Properties\Reservation\ReservationProperties;
use App\Transfers\Reservation\ReservationTransfer;
use Carbon\Carbon;
use DateTime;
use Exception;
use phpDocumentor\Reflection\Types\Boolean;

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

    //##########テーブル取得系##########
    //##########テーブル取得系##########
    //##########テーブル取得系##########

    /**
     * Reservationをすべて取得
     */
    public function getReservations() :ReservationProperties
    {
        $query = Reservation::query()->with('schedule','schedule.movie','sheet',)
            ->where('date','>=',Carbon::now()->format('Y-m-d'))
            ->orderBy('id','asc');

        $reservations = $query->get();
        $dto = ReservationProperties::create();
        $dto->reservations = $reservations;
        return $dto;
    }

    /**
     * 指定したidのReservationを取得
     */
    public function getReservationById($id) :ReservationProperties
    {
        $query = Reservation::query()->with('schedule','sheet','schedule.movie')
            ->where('id',$id);
        //dto作成
        $dto = ReservationProperties::create();

        //レコードがない場合は失敗としてリターン
        if(!$query->exists()){
            $dto->get_isSucced = false;
            return $dto;
        }else{
            $dto->get_isSucced = true;
        }

        $reservation = $query->first();
        //情報をdtoに詰め込む
        $dto->reservation_record = $reservation;
        $dto->id = $reservation->id;
        $dto->date = $reservation->date;
        $dto->dateYmd =Carbon::createFromFormat('Y-m-d H:i:s',$dto->date)->format('Y-m-d');
        $dto->movie_id = $reservation->movie_id;
        $dto->movie_title = $reservation->schedule->movie->title;
        $dto->schedule_id = $reservation->schedule_id;
        $dto->schedule_start_time = $reservation->schedule->start_time;
        $dto->schedule_end_time = $reservation->schedule->end_time;
        $dto->sheet_row = $reservation->sheet->row;
        $dto->sheet_column = $reservation->sheet->column;
        $dto->sheet_id = $reservation->sheet_id;
        $dto->name = $reservation->name;
        $dto->email = $reservation->email;

        return $dto; 
    }

    /**
     * 指定したschedule_idから詳細情報を取得
     */
    public function getScheduleDetail($schedule_id) :ReservationProperties
    {
        $query = Schedule::query()->with(['movie'])
            ->where('id',$schedule_id);
        //dto作成
        $dto = ReservationProperties::create();

        //レコードがない場合は失敗としてリターン
        if(!$query->exists()){
            $dto->get_isSucced = false;
            return $dto;
        }else{
            $dto->get_isSucced = true;
        }

        $schedule = $query->first();
        //情報をdtoに詰め込む
        $dto->date = DateTime::createFromFormat('Y-m-d H:i:s',$schedule->start_time)->format('Y-m-d');
        $dto->movie_id = $schedule->movie_id;
        $dto->movie_title = $schedule->movie->title;
        $dto->schedule_start_time = $schedule->start_time;
        $dto->schedule_end_time = $schedule->end_time;
        return $dto; 
    }

    //##########CRUD操作系##########
    //##########CRUD操作系##########
    //##########CRUD操作系##########

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
            $dto->id = $data->id;
        }
        //store用データをdtoに移す
        $dto->schedule_id = $trans->schedule_id;
        $dto->sheet_id = $trans->sheet_id;
        //日付はY-m-d H:i:sに変換する
        $dto->date = DateTime::createFromFormat('Y-m-d',$trans->date)->format('Y-m-d H:i:s');
        return $dto;
    }

    public function update(ReservationTransfer $trans) :ReservationProperties
    {
        $dto = ReservationProperties::create();
        $dto->update_isSucced = false;

        //新規登録
        Reservation::query()->where('id',$trans->id)->update(
            $trans->update(),
        );
        //処理結果をdtoに格納
        $dto->update_isSucced = true;
        $dto->id = $trans->id;
        return $dto;
    }

    public function delete($reservation_id) :ReservationProperties
    {

        $query = Reservation::query()->where('id',$reservation_id);
        //dto作成
        $dto = ReservationProperties::create();
        $dto->delete_isSucced = false;

        //レコードがない場合は失敗としてリターン
        if(!$query->exists()){
            $dto->delete_isSucced = false;
            $dto->delete_isFound = false;
            return $dto;
        }else{
            //削除
            $data = $query->delete();
            $dto->delete_isSucced = true;
            $dto->delete_isFound = true;
        }
        //処理結果をdtoに格納
        $dto->delete_data = $data;
        $dto->id = $reservation_id;
        return $dto;
    }

    //##########判定系##########
    //##########判定系##########
    //##########判定系##########

    public function ReservationExists($schedule_id,$sheet_id)
    {
        //uniqueキーですでに予約済みか検索
        $query = Reservation::query()
        ->where('schedule_id',$schedule_id)
        ->where('sheet_id',$sheet_id);

        return $query->exists();
    }
}