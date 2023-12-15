<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>映画一覧</title>
</head>
<body>
    <div>映画一覧</div>
    <ul>
    @foreach ($movies as $movie)
        <li>映画のタイトル:{{$movie->title}}</li>
        <div>画像URL:{{$movie->image_url}}</div>
        <img src="{{$movie->image_url}}">
    @endforeach
    </ul>
</body>
</html>
