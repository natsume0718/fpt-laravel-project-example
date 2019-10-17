<div class="form-group">
    <label for="{{ @$id }}">{{ @$label }}</label>
    <div class="input-group">
        <input type="{{ empty($type) ? 'text' : $type }}" class="form-control @if($errors->has($name)) is-invalid @endif"
               id="{{ @$id }}" name="{{ $name }}" placeholder="{{ @$placeholder }}" value="{{ @$value }}">
        @if($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
        @endif
    </div>
</div>
