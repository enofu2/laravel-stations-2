<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
    protected $table = 'schedules';
    protected $fillable = ['movie_id','start_time','end_time'];

    /**
     * railway 14
     * $castsがないとカラム：start_time,end_timeがstringになる。
     * テストコードでformat()をコールしようとするとエラーがでる。
     * Date型なら大丈夫。
     */
    
    protected $casts = [
        'movie_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function movie()
    {   
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function screen()
    {   
        return $this->belongsTo(Screen::class,'screen_id');
    }
    
}
