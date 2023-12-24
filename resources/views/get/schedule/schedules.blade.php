@extends('layouts.app')
@section('title','スケジュール一覧')

@section('head_after')
    <link href={{asset('/css/table/border.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/title/title.css');}} rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h1 class="bigtitle">スケジュール一覧</h1>
    @include('layouts.parts.error.error',['errors' => $errors])
    <hr>
    @foreach($movies as $movie)
        @if(! empty($movie->schedules->count()) )
        <div style="margin : 1em">
            <h2>
                <table> 
                    <tr>
                        <th>{{$movie['id']}}</th>
                        <th><a href="{{ route('movie.detail',['id' => $movie['id']] )}}">{{$movie['title']}}</a></th>
                    </tr>
                </table>
            </h2>
            <table>
                <tr>
                    <th>上映開始</th>
                    <th>上映終了</th>
                </tr>
                @foreach ($movie->schedules as $schedule)
                    <tr>
                        <td><a href="{{ route('admin.schedule.detail',['id' => $schedule['id'] ]) }}">{{$schedule['start_time']}}</a></td>
                        <td><a href="{{ route('admin.schedule.detail',['id' => $schedule['id'] ]) }}">{{$schedule['end_time']}}</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif
    @endforeach
@endsection
