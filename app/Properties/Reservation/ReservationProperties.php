<?php

namespace App\Properties\Reservation;

use App\Properties\Base\BaseProperties;

class ReservationProperties extends BaseProperties
{
    //テーブル関連
    public $id;
    public $date;
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

    //フォーム取得時につかうproperties
    public $create_isDuplicated = false;
}