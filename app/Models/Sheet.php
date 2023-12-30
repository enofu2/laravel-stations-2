<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    public function reservations() {
        return $this->hasMany(Reservation::class,'sheet_id');
    }

    // public function reservations_related($date,$schedule_id) {
    //     $formattedDate = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('H:i:s');
    //     return $this->hasMany(Reservation::class,'sheet_id')
    //     ->where('schedule_id',$schedule_id)
    //     ->where('date',$formattedDate)
    //     ->where('is_cancel',false);
    // }
}
