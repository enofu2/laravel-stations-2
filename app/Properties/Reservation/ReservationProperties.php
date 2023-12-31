<?php

namespace App\Properties\Reservation;

use App\Properties\Base\BaseProperties;
use Illuminate\Database\Eloquent\Collection;

class ReservationProperties extends BaseProperties
{
    //テーブル関連
    public $id;
    public $date;
    //Ymd形式に変換したdate
    public $dateYmd;
    public $email;
    public $name;
    public $is_canceled;
    public $movie_title;
    public $movie_id;
    public $schedule_start_time;
    public $schedule_end_time;
    public $schedule_id;
    public $sheet_row;
    public $sheet_column;
    public $sheet_id;

    //store時につかうproperties
    public $store_isSucced = false;
    public $store_isDuplicated = false;
    public $store_data = [];

    //update時につかうproperties
    public $update_isSucced = false;
    public $update_data = [];

    //delete時につかうproperties
    public $delete_isSucced = false;
    public $delete_isFound = false;
    public $delete_data = [];

    //フォーム取得時につかうproperties
    public $create_isDuplicated = false;

    //admin用の予約一覧に使う
    public Collection $reservations;

    //admin用のレコード取得に使う
    public $reservation_record;
    public $get_isSucced = false;
    public $get_data;
}