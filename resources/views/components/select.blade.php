<div class="form-group">
    <label for="{{ @$id }}">{{ @$label }}</label>
    <select class="form-control @if($errors->has($name)) is-invalid @endif" id="{{ @$id }}" name="{{ @$name }}">
        @foreach($data as $key => $value)
            @if($value == $selected)
                <option value="{{$value}}" selected>{{$key}}</option>
            @else
                <option value="{{$value}}">{{$key}}</option>
            @endif
        @endforeach
    </select>
    @if($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
