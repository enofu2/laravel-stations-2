@extends('layouts.app')
@section('title','座席表')

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/sheet/sheet.css');}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<h1 class="bigtitle">座席表</h1>
@include('layouts.parts.error.error',['errors' => $errors])
<hr>
    <table>
        @foreach (array_keys($sheets) as $rowKey)
        <tr>
            @foreach (array_keys($sheets[$rowKey]) as $columnKey)
            <?php $sheetId = $sheets[$rowKey][$columnKey] ?>
                @if(isset($date) && isset($movie_id) && isset($schedule_id) && isset($sheetId))
                    <td>
                        <a href="{{route('reservations.create',compact('date','movie_id','schedule_id','sheetId'))}}">
                            {{$rowKey}}-{{$columnKey}}
                        </a>
                    </td>                    
                @else
                    <td>{{$rowKey}}-{{$columnKey}}</td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </table>

@endsection