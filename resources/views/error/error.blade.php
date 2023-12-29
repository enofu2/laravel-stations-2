@extends('layouts.app')
@section('title','エラー')

@section('head_after')
    <link href={{asset('/css/title/title.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/table/border.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/button/button.css');}} rel="stylesheet" type="text/css">
@endsection

@section('content')
@include('layouts.parts.error.error',['errors' => $errors])
@endsection
