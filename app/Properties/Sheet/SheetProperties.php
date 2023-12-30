<?php

namespace App\Properties\Sheet;

use App\Properties\Base\BaseProperties;

class SheetProperties extends BaseProperties
{
    //テーブル関連
    public $date;
    public $movie_id;
    public $schedule_id;
    public $sheets = [];
    public $isReserved = [];
}