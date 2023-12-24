@extends('layouts.app')
@section('title','映画一覧')

@section('head_after')
    <link href={{asset('/css/index/index.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/title/title.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/table/border.css');}} rel="stylesheet" type="text/css">
    <link href={{asset('/css/button/button.css');}} rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h1 class="bigtitle">映画一覧</h1>
    <hr>
    @include('layouts.parts.error.error',['errors' => $errors])
    <div>
        <form class="searchbox" method="get" action="{{route('movie.index')}}">
                <div class="radio-wrap">
                    <input type="radio" name="is_showing" value="" checked>すべて
                    <input type="radio" name="is_showing" value="0">公開予定
                    <input type="radio" name="is_showing" value="1">公開中
                </div>
                <input type="text" name="keyword" value="{{$keyword}}"/>
                <input type="submit" value="絞り込み" >
        </form>
    </div>
    {{ $movies->appends(request()->query())->links('vendor.pagination.tailwind') }}
    
    <hr class="separate">
    <div class="listblock">
        <div class="mycnt">
            @foreach ($movies as $movie)
            <div class="item">
                <div class="movietitle textforcewrap mycenter">
                    <a href="{{route('movie.detail' ,['id' => $movie['id']])}}">
                        <strong>{{$movie->title}}</strong>
                    </a>
                </div>
                <div class="mycenter">
                    <img class="image mycenter" src="{{$movie->image_url}}">
                </div>
                <div class="imgurl textforcewrap mycenter">
                    {{$movie->image_url}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection