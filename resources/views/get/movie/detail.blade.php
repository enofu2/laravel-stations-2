<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{$movie['title']}}</title>
        <link href={{asset('/css/app.css');}} rel="stylesheet" type="text/css">
        <link href={{asset('/css/table/border.css');}} rel="stylesheet" type="text/css">
    </head>

    <?php /* debug */ 
        use Carbon\CarbonImmutable;
        //dump($movie,$schedules);
    ?>
    
    <body>
        <div class="listblock">
            <div class="mycnt">
                <div class="item">
                    <div class="movietitle textforcewrap mycenter">
                        <strong>{{$movie['title']}}</strong>
                    </div>
                    <div class="mycenter">
                        <img class="image mycenter" src="{{$movie->image_url}}">
                    </div>
                    <div class="imgurl textforcewrap mycenter">
                        {{$movie->image_url}}
                    </div>
                </div>
            </div>
        </div>
        <div>公開年：</div>
        <div>{{$movie['published_year']}}</div>
        <div>概要：</div>
        <div>{{$movie['description']}}</div>
        <hr>
        <h1 class="bigtitle">上映スケジュール</h1>

        @if(!empty($schedules->count()))
        <table>
            <tr>
                <th>上映開始</th>
                <th>上映終了</th>
            </tr>
            @foreach ($schedules as $schedule)
            <tr>
                <td>{{$schedule['start_time']}}</td>
                <td>{{$schedule['end_time']}}</td>
            </tr>
            @endforeach
        </table>
        @else
        <div>現在、上映予定はありません。</div>
        @endif
    </body>
</html>
