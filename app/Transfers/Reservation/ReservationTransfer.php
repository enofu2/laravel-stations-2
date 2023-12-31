<?php

namespace App\Transfers\Reservation;

use App\Transfers\Base\BaseTransfer;

class ReservationTransfer extends BaseTransfer
{
    //id
    public $id;
    //上映日
    public $date;
    //スケジュールID
    public $schedule_id;
    //シートID
    public $sheet_id;
    //予約者メールアドレス
    public $email;
    //予約者
    public $name;
    //予約キャンセル済み
    public $is_canceled;

    public function store() :array
    {
        return [
            'date' => $this->date,
            'schedule_id' => $this->schedule_id,
            'sheet_id' => $this->sheet_id,
            'email' => $this->email,
            'name' => $this->name,
            'is_canceled' => $this->is_canceled
        ];
    }

    public function update() :array
    {
        return [
            // 'id' => $this->id,
            'date' => $this->date,
            'schedule_id' => $this->schedule_id,
            'sheet_id' => $this->sheet_id,
            'email' => $this->email,
            'name' => $this->name,
            'is_canceled' => $this->is_canceled
        ];
    }

}