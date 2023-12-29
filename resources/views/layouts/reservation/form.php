@extends('layouts.app')
@section('title',$title)

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
    <style>
    input.title{
    width : 500px;
    }
    input.image_url{
        width : 500px;
    }
    input.published_year{
        width : 50px;
    }
    input.genre_name{
        width : 300px;
    }
    textarea.description {
        width : 500px;
        height : 200px;
        min-width: 500px;
        min-height: 100px;
        max-width: 500px;
        max-height: 300px;
    }
    </style>
@endsection

<?php //$record -> $formdataにデータを移す
$formdata['movie_id'] = isset($record['title']) ? $record['title'] : null;
$formdata['schedule_id'] = isset($record['image_url']) ? $record['image_url'] : null;
$formdata['published_year'] = isset($record['published_year']) ? $record['published_year'] : null;
$formdata['description'] = isset($record['description']) ? $record['description'] : null;
$formdata['genre'] = isset($record['genre']['name']) ? $record['genre']['name'] : null;
$formdata['is_showing'] = isset($record['is_showing']) ? $record['is_showing'] : null;
?>

@section('content')
    <form method="post" action="{{$action}}">
        @csrf
        @isset($method)
            @method($method)
        @endif

        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['title'],
            'name' => 'title',
            'type' => 'text',
            'title' => '映画タイトル'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['image_url'],
            'name' => 'image_url',
            'type' => 'url',
            'title' => '画像URL'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['published_year'],
            'name' => 'published_year',
            'type' => 'text',
            'title' => '公開年'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['description'],
            'name' => 'description',
            'textarea' => true,
            'title' => '概要'
            ])
        @include('layouts.parts.form.formbox', [
            'defaultValue' => $formdata['genre'],
            'name' => 'genre',
            'type' => 'text',
            'title' => 'ジャンル'
            ])
        @include('layouts.parts.form.formbox', [
            'withLabel' => false,
            'defaultValue' => '0',
            'name' => 'is_showing',
            'type' => 'hidden',
            'title' => '公開中かどうか'
            ])
        @include('layouts.parts.form.formbox', [
            'withLabel' => true,
            'defaultValue' => '1',
            'name' => 'is_showing',
            'type' => 'checkbox',
            'title' => '公開中かどうか',
            'required' => $formdata['is_showing'] == 1 ? 'checked' : '',
            ])
        <input class='yes' type="submit" value="{{$buttonLabel}}" >
    </form>
    @include('layouts.parts.error.error',['errors' => $errors])
@endsection