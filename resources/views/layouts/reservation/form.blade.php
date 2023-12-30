<?php
/**
 * @var App\Properties\Reservation\ReservationProperties $dto
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

<?php //$dto -> $formdataにデータを移す
$formdata['movie_id'] = isset($dto->movie_id) ? $dto->movie_id : null;
$formdata['movie_title'] = isset($dto->movie_title) ? $dto->movie_title : null;
$formdata['schedule_id'] = isset($dto->schedule_id) ? $dto->schedule_id : null;
$formdata['sheet_id'] = isset($dto->sheet_id) ? $dto->sheet_id : null;
$formdata['schedule_start_time'] = isset($dto->schedule_start_time) ? $dto->schedule_start_time : null;
$formdata['schedule_end_time'] = isset($dto->schedule_end_time) ? $dto->schedule_end_time : null;
$formdata['sheet_row'] = isset($dto->sheet_row) ? $dto->sheet_row : null;
$formdata['sheet_column'] = isset($dto->sheet_column) ? $dto->sheet_column : null;
$formdata['date'] = isset($dto->date) ? $dto->date : null;
$formdata['name'] = isset($dto->name) ? $dto->name : null;
$formdata['email'] = isset($dto->email) ? $dto->email : null;
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
    @include('layouts.parts.error.error')
@endsection