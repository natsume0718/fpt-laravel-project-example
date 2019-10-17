@if ($errors->any())
    @foreach ($errors->all() as $error)
        @component('components.alert', ['type' => 'danger'])
            {{ $error }}
        @endcomponent
    @endforeach
@endif
