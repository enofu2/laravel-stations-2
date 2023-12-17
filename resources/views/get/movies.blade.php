<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>映画一覧</title>
        <link href={{asset('/css/app.css');}} rel="stylesheet" type="text/css">
        <link href={{asset('/css/index/index.css');}} rel="stylesheet" type="text/css">
    </head>

    <body>
        <h1 class="bigtitle">映画一覧</h1>
        <form method="get" action="{{route('global.index')}}">
                <div class="radio-wrap">
                    <input type="radio" name="is_showing" value="" checked>すべて
                    <input type="radio" name="is_showing" value="0">公開予定
                    <input type="radio" name="is_showing" value="1">公開中
                </div>
                <input type="text" name="keyword" value="{{$keyword}}"/>
                <input type="submit" value="絞り込み" >
        </form>
        {{ $movies->appends(request()->query())->links('vendor.pagination.tailwind') }}
        <hr>
        <div class="listblock">
            <div class="mycnt">
                @foreach ($movies as $movie)
                <div class="item">
                    <div class="movietitle textforcewrap mycenter">
                        <strong>{{$movie->title}}</strong>
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
    </body>
</html>
