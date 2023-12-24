<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Schedule\CreateScheduleRequest;
use App\Http\Requests\Schedule\DeleteScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{

    public function store(CreateScheduleRequest $request,$id)
    {
        //dd($request['movie_id']);

        try {
            $isSucceed = DB::transaction(function () use ($request,$id) {
                Schedule::create([
                    'movie_id' => $id,
                    'start_time' => date('Y-m-d H:i:s', strtotime($request['start_time_date'] .' ' .$request['start_time_time'] ) ),
                    'end_time' => date('Y-m-d H:i:s', strtotime($request['end_time_date'] .' ' .$request['end_time_time'] ) ),
                ]);
                
                return true;
            });
        } catch (QueryException $e) {
            $errors = [
                'error-msg' => "例外が発生しました",
                "log" => $e->getMessage()
            ];
            return response(view('error.error',['errors' => $errors ]),500,[]);
        }
        
        if ($isSucceed) {
            return redirect()->route('movie.detail',['id' => $id])
                ->with('message', "スケジュールを新規作成しました");
        }else {
            $errors =['error-msg' => "更新に失敗しました"];
            return response(view('error.error',['errors' => $errors ]),500,[]);
        }
    }

    public function update(UpdateScheduleRequest $request,$id)
    {
        try {
            $isSucceed = DB::transaction(function () use ($request,$id) {
                $query = Schedule::query()->where('id',$id);
    
                if ($query->exists()) {
                    $query->update([
                        'start_time' => date('Y-m-d H:i:s', strtotime($request['start_time_date'] .' ' .$request['start_time_time'] ) ),
                        'end_time' => date('Y-m-d H:i:s', strtotime($request['end_time_date'] .' ' .$request['end_time_time'] ) ),
                    ]);
                }
                
                return true;
            });
        } catch (QueryException $e) {
            $errors = [
                'error-msg' => "例外が発生しました",
                "log" => $e->getMessage()
            ];
            return response(view('error.error',['errors' => $errors ]),500,[]);
        }
        
        if ($isSucceed) {
            return redirect()->route('movie.detail',['id' => $request['movie_id']])
                ->with('message', "スケジュールを更新しました");
        }else {
            $errors =['error-msg' => "更新に失敗しました"];
            return response(view('error.error',['errors' => $errors ]),500,[]);
        }
    }

    public function delete($id)
    {
        $record = Schedule::query()->where('id',$id);
        if ($record->exists()) {
            $movieId = $record->first()['movie_id'];
            $record->delete();
            session()->flash('message' ,"[id:{$id}]の情報削除しました");            
            return redirect()->route('movie.detail',['id' => $movieId]);
        }else{
            $errors =['error-msg' => "該当idの情報が見つかりません"];
            return response(view('error.error',['errors' => $errors ]),404,[]);
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
            $errors = ['error-msg' => "該当idの情報が見つかりません"];
            return response(view('error.error',['errors' => $errors ]),500);
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
            $errors = ['error-msg' => "該当idの情報が見つかりません"];
            return response(view('error.error',['errors' => $errors ]),500);
        }
    }

}
