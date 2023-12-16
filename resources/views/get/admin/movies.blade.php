<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者映画一覧</title>
</head>
<body>
    <h1>管理者映画一覧</h1>
    @if(session('message'))
        <div style='background-color:#33FF33'>{{session('message')}}</div>
    @endif
    <input type="button" onclick="location.href='{{ route('admin.create')}}'" value="映画を新規登録">
    <table border="1">
        <tr>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>登録日時</th>
            <th>更新日時</th>
        </tr>
        @foreach ($movies as $movie)
        <tr>
            <td>{{$movie->id}}</td>
            <td>{{$movie->title}}</td>
            <td>{{$movie->image_url}}</td>
            <td>{{$movie->published_year}}</td>
            <td>{{$movie->is_showing ? '上映中' : '上映予定'}}</td>
            <td>{{$movie->description}}</td>
            <td>{{$movie->created_at}}</td>
            <td>{{$movie->updated_at}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
