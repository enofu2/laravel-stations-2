<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['movie_id','start_time','end_time'];

    /**
     * railway 14
     * $castsがないとカラム：start_time,end_timeがstringになる。
     * テストコードでformat()をコールしようとするとエラーがでる。
     * Date型なら大丈夫。
     */
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];
    

    use HasFactory;
}
