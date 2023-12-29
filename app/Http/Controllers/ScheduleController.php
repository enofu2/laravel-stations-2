<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\CreateScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    public function store(CreateScheduleRequest $request,$id)
    {
        
        $startDateTime = date('Y-m-d H:i:s', strtotime($request['start_time_date'] .' ' .$request['start_time_time'] ));
        $endDateTime = date('Y-m-d H:i:s', strtotime($request['end_time_date'] .' ' .$request['end_time_time'] ));
        /*
        if(! $this->isDateTimeAfterMinutes(5,$startDateTime,$endDateTime))
        {
            return redirect()->back()
                ->withErrors('日時の指定が不正です。確認してください。');
        }
        */
        try {
            $isSucceed = DB::transaction(function () use ($request,$id,$startDateTime,$endDateTime) {
                Schedule::create([
                    'movie_id' => $id,
                    'start_time' => $startDateTime,
                    'end_time' => $endDateTime,
                ]);
                
                return true;
            });
        } catch (QueryException $e) {
            session()->flash('error' ,['msg' => "例外が発生しました",'exception' => $e->getMessage()]);
            return response(view('error.error'),500,[]);
        }
        
        if ($isSucceed) {
            session()->flash('success' ,['msg' => "スケジュールを新規作成しました"]);
            return redirect()->route('admin.movie.detail',['id' => $id]);
        }else {
            session()->flash('error' ,['msg' => "更新に失敗しました"]);
            return response(view('error.error'),500,[]);
        }
    }

    public function update(UpdateScheduleRequest $request,$id)
    {
        
        $startDateTime = date('Y-m-d H:i:s', strtotime($request['start_time_date'] .' ' .$request['start_time_time'] ));
        $endDateTime = date('Y-m-d H:i:s', strtotime($request['end_time_date'] .' ' .$request['end_time_time'] ));
        /*
        if(! $this->isDateTimeAfterMinutes(5,$startDateTime,$endDateTime))
        {
            return redirect()->back()
                ->withErrors('日時の指定が不正です。確認してください。');
        }
        */

        try {
            $isSucceed = DB::transaction(function () use ($request,$id,$startDateTime,$endDateTime) {
                $query = Schedule::query()->where('id',$id);
    
                if ($query->exists()) {
                    $query->update([
                        'start_time' => $startDateTime,
                        'end_time' => $endDateTime,
                    ]);
                }
                
                return true;
            });
        } catch (QueryException $e) {
            session()->flash('error' ,['msg' => "例外が発生しました",'exception' => $e->getMessage()]);
            return response(view('error.error'),500,[]);
        }
        
        if ($isSucceed) {
            session()->flash('success' ,['msg' => "スケジュールを更新しました"]);
            return redirect()->route('admin.movie.detail',['id' => $request['movie_id']]);
        }else {
            session()->flash('error' ,['msg' => "更新に失敗しました"]);
            return response(view('error.error'),500,[]);
        }
    }

    public function delete($id)
    {
        $record = Schedule::query()->where('id',$id);
        if ($record->exists()) {
            $movieId = $record->first()['movie_id'];
            $record->delete();
            session()->flash('success' ,"[id:{$id}]のスケジュール情報を削除しました");            
            return redirect()->route('movie.detail',['id' => $movieId]);
        }else{
            session()->flash('error',"該当idの情報が見つかりません");
            return response(view('error.error'),404,[]);
        }
    }

    public function schedules() 
    {
        $movies = Movie::query()
            ->with(['schedules' => function($query){
                $query->orderBy('schedules.start_time','asc');
            }]);
        return view('get.schedule.schedules', ['movies' => $movies->get()]);
    }

    public function detail($id)
    {
        $schedule = Schedule::query()->with('movie')
            ->where('id',$id)
            ->orderBy('start_time','asc');

        if($schedule->exists()) {
            return view('get.schedule.detail',['schedule' => $schedule->first()]);
        }else{
            session()->flash('error',"該当idの情報が見つかりません");
            return response(view('error.error'),500);
        }
    }

    public function create($id)
    {
        $record = [
            'movie_id' => $id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),
        ];
        return view('get.schedule.create',['record' => $record,'id' => $id]);
    }

    public function edit($id)
    {
        $record = Schedule::query()->where('id',$id);

        if ($record->exists()) {
            return view('get.schedule.edit',['id'=>$id,'record' => $record->first()]);
        }else{
            session()->flash('error',"該当idの情報が見つかりません");
            return response(view('error.error'),500);
        }
    }

    // /**
    //  * in-class support functions
    //  * 
    //  */

    // protected function isDateTimeAfterMinutes($minutes,$fromDateTime,$toDateTime)
    // {
    //     $from = CarbonImmutable::create($fromDateTime);
    //     $to = CarbonImmutable::create($toDateTime);

    //     if ($to->gte($from->addMinutes($minutes)) )
    //     {
    //         return true;
    //     }
    //     return false;
    // }
}
