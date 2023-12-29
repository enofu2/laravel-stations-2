@extends('layouts.app')
@section('title','座席表')

@section('head_after')
    <link href={{asset('/css/title/title.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/table/border.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/button/button.css');}} rel="stylesheet" type="text/css">
@endsection

@section('content')
<h1>座席表</h1>
    @if(session('message'))
        <div style='background-color:#33FF33'>{{session('message')}}</div>
    @endif
    @if(session('err-message'))
        <div style='background-color:#DD3333'>{{session('err-message')}}</div>
    @endif
    @if($errors->any())
        <div style='background-color:#DD3333'><strong>エラー</strong>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <table border="1">
        <tr>
        @foreach ($columns as $column)
            <th></th>
        @endforeach
        </tr>

        @foreach ($rows as $row)
        <tr>
            @foreach ($columns as $column)
            <td>{{$row['row']}}-{{$column['column']}}</td>
            @endforeach
        </tr>
        @endforeach
    </table>

@endsection