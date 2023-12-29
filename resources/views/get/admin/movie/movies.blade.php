@extends('layouts.app')
@section('title','管理者映画一覧')

@section('head_after')
    <link href="{{asset('/css/title/title.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/table/border.css');}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/button/button.css');}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <h1 class="bigtitle">管理者映画一覧</h1>
    <hr>
    @include('layouts.parts.error.error',['errors' => $errors])
    <form action="{{route('admin.create')}}">
        <button class="yes" type="submit">映画を新規登録</button>
    </form>
    <table>
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
                    <button class="yes" type="submit">編集</button>
                </form>
            </td>
            <td>
                <form method="POST" action="{{route('admin.delete',['id'=>$movie->id])}}" onsubmit="if(confirm('削除しますか?')){return Boolean('1');}else{return Boolean('');}">
                    @method('delete')
                    @csrf
                    <input class="no" type="submit" value="削除">
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
@endsection
