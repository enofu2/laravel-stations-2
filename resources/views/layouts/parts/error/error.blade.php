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