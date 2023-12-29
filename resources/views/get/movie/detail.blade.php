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
                    <td>{{$schedule['start_time']}}</td>
                    <td>{{$schedule['end_time']}}</td>
                </tr>
            @endforeach
        </table>
        @else
        <div>現在、上映予定はありません。</div>
        @endif
@endsection