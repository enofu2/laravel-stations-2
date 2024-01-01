@extends('layouts.app')
@section('title',$movie['title'])

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h1 class="bigtitle">映画詳細</h1>
    @include('layouts.parts.error.error',['errors' => $errors])
    <hr>
    <div class="listblock">
            <div class="mycnt">
                <div class="item">
                    <div class="movietitle textforcewrap mycenter">
                        <strong>{{$movie['title']}}</strong>
                    </div>
                    <div class="mycenter">
                        <img class="image mycenter" src="{{$movie->image_url}}">
                    </div>
                    <div class="imgurl textforcewrap mycenter">
                        {{$movie->image_url}}
                    </div>
                </div>
            </div>
        </div>
        <div>公開年：</div>
        <div>{{$movie['published_year']}}</div>
        <div>概要：</div>
        <div>{{$movie['description']}}</div>
        <div>上映中かどうか</div>
        <div>{{$movie['is_showing'] ? '上映中' : '上映予定'}}</div>
        <hr>
        <h1 class="bigtitle">上映スケジュール</h1>

        @if(!empty($schedules->count()))
        <table>
            <tr>
                <th>上映開始</th>
                <th>上映終了</th>
            </tr>
            @foreach ($movie->schedules as $schedule)
                <tr>
                    <td><a href="{{ route('admin.schedules.detail',['id' => $schedule['id'] ]) }}">{{$schedule['start_time']}}</a></td>
                    <td><a href="{{ route('admin.schedules.detail',['id' => $schedule['id'] ]) }}">{{$schedule['end_time']}}</a></td>
                </tr>
            @endforeach
        </table>
        @else
        <div>現在、上映予定はありません。</div>
        @endif
        <form  action="{{ route('admin.schedules.create',['id' => $movie['id']]) }}">
            <button class="yes" type="submit">スケジュール作成</button>
        </form>
@endsection

