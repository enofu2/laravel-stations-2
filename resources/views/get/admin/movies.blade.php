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
    <input type="button" onclick="location.href='{{route('admin.create')}}'" value="映画を新規登録">
    <table border="1">
        <tr>
            <th></th>
            <th></th>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>ジャンル名</th>
            <th>ジャンルID</th>
            <th>登録日時</th>
            <th>更新日時</th>
        </tr>
        @foreach ($movies as $movie)
        <tr>
            <td>
                <form  action="{{ route('admin.edit',['id'=>$movie->id])}}">
                    <button style="white-space: nowrap" type="submit">編集</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{route('admin.delete',['id'=>$movie->id])}}" onsubmit="if(confirm('削除しますか?')){return Boolean('1');}else{return Boolean('');}">
                    @method('delete')
                    @csrf
                    <input type="submit" value="削除">
                </form>
            </td>
            <td>{{$movie['id']}}</td>
            <td>{{$movie['title']}}</td>
            <td>{{$movie['image_url']}}</td>
            <td>{{$movie['published_year']}}</td>
            <td>{{$movie['is_showing'] ? '上映中' : '上映予定'}}</td>
            <td>{{$movie['description']}}</td>
            <td>{{$movie['genre']['name']}}</td>
            <td>{{$movie['genre']['id']}}</td>
            <td>{{$movie['created_at']}}</td>
            <td>{{$movie['updated_at']}}</td>

        </tr>
        @endforeach
    </table>
</body>
</html>
