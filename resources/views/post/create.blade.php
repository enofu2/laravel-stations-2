<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>管理者：映画登録画面</title>
        <link href={{asset('/css/form/form.css');}} rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>管理者：映画登録画面</h1>
        <form method="post" action="{{route('admin.store')}}">
            @csrf
            <div class="formbox">
                <label for="title"><div>映画タイトル</div>
                    <input class="title" type="text" name="title" id="title" value="{{ old('title',$record['title']) }}" required/>
                </label>
            </div>
            <div class="formbox">
                <label for="image_url"><div>画像URL</div>
                    <input class="image_url" type="url" name="image_url" id="image_url"  value="{{old('image_url',$record['image_url']) }}" placeholder="http(s)://example.com" pattern="https?://.*" size="50" required/>
                </label>
            </div>
            <div class="formbox">
                <label for="published_year"><div>公開年</div>
                    <input class="published_year" type="text" name="published_year" id="published_year" value="{{ old('published_year',$record['published_year']) }}" required/>
                </label>
            </div>
            <div class="formbox">
                <label for="description"><div>概要</div>
                    <textarea class="description" name="description" id="description" wrap="soft" required>{{ old('description',$record['description']) }}</textarea>
                </label>
            </div>
            <div class="formbox">
                <label for="genre_name"><div>ジャンル</div>
                    <input class="genre_name" type="text" name="title" id="title" value="{{ old('genre_name',$record['genre_name']) }}"  required/>
                </label>
            </div>
            <div class="formbox">
                <label for="is_showing"><div>公開中かどうか</div>
                    <input type="hidden" name="is_showing" id="is_showing" value="0"/>
                    <input type="checkbox" name="is_showing" id="is_showing" value="1" @if (old('is_showing','') == '1') checked @endif/>
                </label>
            </div>
            <input type="submit" value="送信" >
        </form>
        @if($errors->any())
            <div style='background-color:#FFDD00'><strong>エラー</strong>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif
    </body>
</html>
