<div class="formbox">
    @if($withLabel ?? true)
        <label for="{{$name}}"><div>{{$title}}</div>
    @endif
    @if(isset($text))
        <div>
            {{$text}}
        </div>
    @endif
    @if($textarea ?? false)
        <textarea class="{{$name}}" name="{{$name}}" id="{{$name}}" wrap="{{$wrap ?? 'soft'}}" {{$required ?? 'required'}}>{{ old($name) ?? $defaultValue ?? '' }}</textarea>
    @else
        <input class="{{$name}}" type="{{$type}}" name="{{$name}}" id="{{$name}}" value="{{ old($name) ?? $defaultValue ?? '' }}" {{$required ?? 'required'}}/>
    @endif
    @if($withLabel ?? true)
        </label>
    @endif
</div>