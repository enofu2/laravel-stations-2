<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $table = 'screens';
    protected $casts = [];
    protected $guarded = [''];

    use HasFactory;
}
