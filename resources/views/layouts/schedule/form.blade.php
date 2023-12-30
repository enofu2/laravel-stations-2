@extends('layouts.app')
@section('title',$title)

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <form method="post" action="{{$action}}">
        @csrf
        @isset($method)
            @method($method)
        @endif

        @include('layouts.parts.form.formbox', ['defaultValue' => isset($record['start_time']) ? $record['start_time']->format('Y-m-d') : null, 'name' => 'start_time_date', 'type' => 'date', 'title' => '開始日付'])
        @include('layouts.parts.form.formbox', ['defaultValue' => isset($record['start_time']) ? $record['start_time']->format('H:i') : null, 'name' => 'start_time_time', 'type' => 'time', 'title' => '開始時間'])
        @include('layouts.parts.form.formbox', ['defaultValue' => isset($record['end_time']) ? $record['end_time']->format('Y-m-d') : null, 'name' => 'end_time_date', 'type' => 'date', 'title' => '終了日付'])
        @include('layouts.parts.form.formbox', ['defaultValue' => isset($record['end_time']) ? $record['end_time']->format('H:i') : null, 'name' => 'end_time_time', 'type' => 'time', 'title' => '終了日時'])
        @include('layouts.parts.form.formbox', ['withLabel' => false, 'defaultValue' => isset($record['movie_id']) ? $record['movie_id'] : null, 'name' => 'movie_id', 'type' => 'hidden'])
        <input style="border: 1px solid;color: #FFFFFF;background-color :darkgreen" type="submit" value="{{$buttonLabel}}" >
    </form>
    @include('layouts.parts.error.error')
@endsection