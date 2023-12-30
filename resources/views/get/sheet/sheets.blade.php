<?php
/**
 * @var App\Properties\Sheet\SheetProperties $dto
 */
?>
@extends('layouts.app')
@section('title','座席表')

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/sheet/sheet.css');}}" rel="stylesheet" type="text/css">
@endsection

<?php //$dto -> $viewdataにデータを移す
$viewdata['sheets'] = isset($dto->sheets) ? $dto->sheets : null;
$viewdata['isReserved'] = isset($dto->isReserved) ? $dto->isReserved : null;
$viewdata['movie_id'] = isset($dto->movie_id) ? $dto->movie_id : null;
$viewdata['schedule_id'] = isset($dto->schedule_id) ? $dto->schedule_id : null;
$viewdata['date'] = isset($dto->date) ? $dto->date : null;

dump($dto,$viewdata,'sheets.blade');
?>

@section('content')
<h1 class="bigtitle">座席表</h1>
@include('layouts.parts.error.error',['errors' => $errors])
<hr>
    <table>
        @foreach (array_keys($viewdata['sheets']) as $rowKey)
        <tr>
            @foreach (array_keys($viewdata['sheets'][$rowKey]) as $columnKey)
            <?php
                $sheetId = $viewdata['sheets'][$rowKey][$columnKey];
                //dd($viewdata['date'],$viewdata['movie_id'],$viewdata['schedule_id'],$sheetId);
             ?>
                @if(isset($viewdata['date']) && isset($viewdata['movie_id']) && isset($viewdata['schedule_id']) && isset($sheetId))
                        @if(isset($viewdata['isReserved'][$rowKey][$columnKey]))
                        <td class="unavailable">
                            {{$rowKey}}-{{$columnKey}}
                        @else
                        <td>
                            <a href="{{route('reservations.create',[
                                'movie_id' => $viewdata['movie_id'],
                                'schedule_id' => $viewdata['schedule_id'],
                                'date' => $viewdata['date'],
                                'sheetId' => $sheetId,
                                ])}}">
                                {{$rowKey}}-{{$columnKey}}
                            </a>
                        @endif
                    </td>                    
                @else
                    <td>{{$rowKey}}-{{$columnKey}}</td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </table>

@endsection