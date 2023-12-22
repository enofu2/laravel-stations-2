<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>座席表</title>
</head>
<body>
    <h1>座席表</h1>
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
    <table border="1">
        <tr>
        @foreach ($columns as $column)
            <th></th>
        @endforeach
        </tr>

        @foreach ($rows as $row)
        <tr>
            @foreach ($columns as $column)
            <td>{{$row['row']}}-{{$column['column']}}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
</body>
</html>
