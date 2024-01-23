@extends('layouts.app')
@section('title','スケジュール詳細：' .$schedule->movie['title'])

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h1 class="bigtitle">スケジュール詳細</h1>
    @include('layouts.parts.error.error',['errors' => $errors])
    <hr>
    <div>
        <table>
            <tr>
                <th>上映開始</th>
                <th>上映終了</th>
            </tr>
            <tr>
                <td>{{$schedule['start_time']}}</td>
                <td>{{$schedule['end_time']}}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div>
        <form action="{{ route('admin.schedules.edit',['scheduleId' => $schedule['id']])}}">
            <button style="border: 1px solid;color: #FFFFFF;background-color :tomato; white-space: nowrap" type="submit">編集</button>
        </form>
        <form method="POST" action="{{route('admin.schedules.delete',['id' => $schedule['id']])}}" onsubmit="if(confirm('削除しますか?')){return Boolean('1');}else{return Boolean('');}">
            @method('delete')
            @csrf
            <input style="border: 1px solid;color: #FFFFFF;background-color :darkgreen" type="submit" value="削除">
        </form>
    </div>
@endsection