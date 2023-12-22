<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>エラー</title>
</head>
<body>
    @if(! empty($errors))
        <div style='background-color:#DD3333'><strong>エラー</strong>
            @foreach ($errors as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
</body>
</html>
