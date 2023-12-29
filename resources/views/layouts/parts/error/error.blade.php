
@if ($messages = Session::get('success'))
@foreach($messages as $message)
<div class="success">
    <strong>{{ $message }}</strong>
</div>
@endforeach
@endif

@if ($messages = Session::get('error'))
@foreach($messages as $message)
<div class="error">
    <strong>{{ $message }}</strong>
</div>
@endforeach
@endif

@if ($messages = Session::get('warning'))
@foreach($messages as $message)
<div class="warning">
    <strong>{{ $message }}</strong>
</div>
@endforeach
@endif

@if ($messages = Session::get('info'))
@foreach($messages as $message)
<div class="info">
    <strong>{{ $message }}</strong>
</div>
@endforeach
@endif

@if($errors->any())
    <div style='background-color:#DD3333'><strong>エラー</strong>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
@endif