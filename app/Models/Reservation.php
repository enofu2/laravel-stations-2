<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $casts = [
        'date' => 'date',
        'is_canceled' => 'boolean',
    ];
    protected $guarded = [''];

    public function schedule()
    {   
        return $this->belongsTo(Schedule::class,'schedule_id');
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class, 'sheet_id');
    }
    use HasFactory;
}
