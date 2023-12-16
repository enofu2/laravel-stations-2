<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>管理者：映画登録画面</title>
    </head>
    <body>
        <h1>管理者：映画登録画面</h1>
        <form method="post" action="{{route('admin.store')}}">
            @csrf
            <div>
                <label for="title">映画タイトル
                    <input type="text" name="title" id="title" value="{{ old('title','') }}"  required/>
                </label>
            </div>
            <div>
                <label for="image_url">画像URL
                    <input type="url" name="image_url" id="image_url"  value="{{ old('image_url','') }}"  placeholder="http(s)://example.com" pattern="https?://.*" size="50" required/>
                </label>
            </div>
            <div>
                <label for="published_year">公開年
                    <input type="text" name="published_year" id="published_year" value="{{ old('published_year','') }}"  required/>
                </label>
            </div>
            <div>
                <label for="description">概要
                    <textarea name="description" id="description" cols="50" rows="20" wrap="soft" required>{{ old('description','') }}</textarea>
                </label>
            </div>
            <div>
                <label for="is_showing">公開中かどうか
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
