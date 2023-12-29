@extends('layouts.app')
@section('title',$title)

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
    <style>
    input.name{
        width : 300px;
    }
    input.email{
        width : 300px;
    }
    </style>
@endsection

<?php //$record -> $formdataにデータを移す
$formdata['movie_id'] = isset($record['movie_id']) ? $record['movie_id'] : null;
$formdata['schedule_id'] = isset($record['schedule_id']) ? $record['schedule_id'] : null;
$formdata['sheet_id'] = isset($record['sheet_id']) ? $record['sheet_id'] : null;
$formdata['date'] = isset($record['date']) ? $record['date'] : null;
$formdata['name'] = isset($record['name']) ? $record['name'] : null;
$formdata['email'] = isset($record['email']) ? $record['email'] : null;
?>

@section('content')
    <form method="post" action="{{$action}}">
        @csrf
        @isset($method)
            @method($method)
        @endif

        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['movie_id'],
            'name' => 'movie_id',
            'type' => 'hidden',
            'title' => '映画作品'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['schedule_id'],
            'name' => 'schedule_id',
            'type' => 'hidden',
            'title' => '上映スケジュール'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['sheet_id'],
            'name' => 'sheet_id',
            'type' => 'hidden',
            'title' => '座席'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['date'],
            'name' => 'date',
            'type' => 'hidden',
            'title' => '日付'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['name'],
            'name' => 'name',
            'type' => 'text',
            'title' => '予約者氏名'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['email'],
            'name' => 'email',
            'type' => 'email',
            'title' => '予約者メールアドレス'
            ])
        <input class='yes' type="submit" value="{{$buttonLabel}}" >
    </form>
    @include('layouts.parts.error.error',['errors' => $errors])
@endsection