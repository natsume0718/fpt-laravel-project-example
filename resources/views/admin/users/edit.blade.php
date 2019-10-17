@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    {{ __('Create') . ' ' .  __('User') }}
                @endslot

                @slot('card_footer')
                    {{ __('Input your data') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="post" action="{{ route('admin.users.update', $model->id) }}">
                    @csrf
                    @method('PUT')
                    @component('components.input', [
                            'type' => 'text',
                            'name' => 'name',
                            'id' => 'name',
                            'label' => __('Name'),
                            'placeholder' => __('Name'),
                            'value' => $model->name,
                            'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                            'type' => 'email',
                            'name' => 'email',
                            'id' => 'email',
                            'label' => __('Email'),
                            'placeholder' => __('Email'),
                            'value' => $model->email,
                            'errors' => $errors,])
                    @endcomponent

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}
                    </button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> {{ __('Reset') }}
                    </button>
                </form>

            @endcomponent
        </div>
    </div>
@endsection
