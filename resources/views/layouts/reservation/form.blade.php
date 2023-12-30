<?php
/**
 * @var App\Properties\Base\Reservation\ReservationProperties $record
 */
?>
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
$formdata['movie_id'] = isset($record->movie_id) ? $record->movie_id : null;
$formdata['movie_title'] = isset($record->movie_title) ? $record->movie_title : null;
$formdata['schedule_id'] = isset($record->schedule_id) ? $record->schedule_id : null;
$formdata['sheet_id'] = isset($record->sheet_id) ? $record->sheet_id : null;
$formdata['schedule_start_time'] = isset($record->schedule_start_time) ? $record->schedule_start_time : null;
$formdata['schedule_end_time'] = isset($record->schedule_end_time) ? $record->schedule_end_time : null;
$formdata['sheet_row'] = isset($record->sheet_row) ? $record->sheet_row : null;
$formdata['sheet_column'] = isset($record->sheet_column) ? $record->sheet_column : null;
$formdata['date'] = isset($record->date) ? $record->date : null;
$formdata['name'] = isset($record->name) ? $record->name : null;
$formdata['email'] = isset($record->email) ? $record->email : null;
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
            'title' => '映画作品',
            'text' => $formdata['movie_title'],
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['schedule_id'],
            'name' => 'schedule_id',
            'type' => 'hidden',
            'title' => '上映スケジュール',
            'text' => $formdata['schedule_start_time'] .'～'. $formdata['schedule_end_time'],
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['sheet_id'],
            'name' => 'sheet_id',
            'type' => 'hidden',
            'title' => '座席',
            'text' => $formdata['sheet_row'] .'-'. $formdata['sheet_column'],
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['date'],
            'name' => 'date',
            'type' => 'hidden',
            'title' => '日付',
            'text' => $formdata['date'],
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