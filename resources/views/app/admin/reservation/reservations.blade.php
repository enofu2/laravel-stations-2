<?php
/**
 * @var App\Properties\Reservation\ReservationProperties $dto
 */
?>

@extends('layouts.app')
@section('title','管理者 | 予約一覧')

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
@endsection

<?php //$dto -> $viewdataにデータを移す
$viewdata['reservations'] = isset($dto->reservations) ? $dto->reservations : null;
// $viewdata['movie_title'] = isset($dto->movie_title) ? $dto->movie_title : null;
// $viewdata['schedule_id'] = isset($dto->schedule_id) ? $dto->schedule_id : null;
// $viewdata['sheet_id'] = isset($dto->sheet_id) ? $dto->sheet_id : null;
// $viewdata['schedule_start_time'] = isset($dto->schedule_start_time) ? $dto->schedule_start_time : null;
// $viewdata['schedule_end_time'] = isset($dto->schedule_end_time) ? $dto->schedule_end_time : null;
// $viewdata['sheet_row'] = isset($dto->sheet_row) ? $dto->sheet_row : null;
// $viewdata['sheet_column'] = isset($dto->sheet_column) ? $dto->sheet_column : null;
// $viewdata['date'] = isset($dto->date) ? $dto->date : null;
// $viewdata['name'] = isset($dto->name) ? $dto->name : null;
// $viewdata['email'] = isset($dto->email) ? $dto->email : null;
?>

@section('content')
    <h1 class="bigtitle">(管理者)予約一覧</h1>
    <hr>
    @include('layouts.parts.error.error',['errors' => $errors])
    <form action="{{route('admin.reservations.create')}}">
        <button class="yes" type="submit">予約を新規登録</button>
    </form>
    <table>
        <tr>
            <th></th>
            <th>ID</th>
            <th>映画作品</th>
            <th>座席</th>
            <th>日時</th>
            <th>氏名</th>
            <th>メールアドレス</th>
        </tr>
        @foreach ($viewdata['reservations']  as $item)
        <tr>
            <td>
                <form  action="{{ route('admin.reservations.edit',['id' => $item->id ]) }}">
                    <button class="yes" type="submit">編集</button>
                </form>
            </td>
            <th>{{$item['id']}}</th>
            <th>{{$item->schedule->movie->title}}</th>
            <th>{{strtoupper($item->sheet->row)}}{{$item->sheet->column}}</th>
            <th>{{$item['date']->format('Y-m-d H:i:s')}}</th>
            <th>{{$item['name']}}</th>
            <th>{{$item['email']}}</th>
        </tr>
        @endforeach
    </table>
@endsection
