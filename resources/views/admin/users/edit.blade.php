@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('Update') . ' ' .  __('User') }} : {{ $model->id }}
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
                        'type' => 'text',
                        'name' => 'username',
                        'id' => 'username',
                        'label' => __('Username'),
                        'placeholder' => __('Username'),
                        'value' => $model->username,
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

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'phone_number',
                        'id' => 'phone_number',
                        'label' => __('Phone Number'),
                        'placeholder' => __('Phone Number'),
                        'value' => $model->phone_number,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'address',
                        'id' => 'address',
                        'label' => __('Address'),
                        'placeholder' => __('Address'),
                        'value' => $model->address,
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
