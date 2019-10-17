@if(session()->get('success'))
    @component('components.alert', ['type' => 'success'])
        {{ session()->get('success') }}
    @endcomponent
@endif
