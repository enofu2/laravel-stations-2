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

    use HasFactory;
}
