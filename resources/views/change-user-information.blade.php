@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Change User Information</h5>
        <div class="card-body">
            @include('includes.error-alert')
            @include('includes.success-alert')

            <form method="post" action="{{ route('user.edit-information') }}">
                @csrf
                @method('PUT')
                @component('components.input', [
                    'type' => 'text',
                    'name' => 'name',
                    'id' => 'name',
                    'label' => __('Name'),
                    'placeholder' => __('Name'),
                    'value' => auth()->user()->name,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'text',
                    'name' => 'username',
                    'id' => 'username',
                    'label' => __('Username'),
                    'placeholder' => __('Username'),
                    'value' => auth()->user()->username,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'email',
                    'label' => __('Email'),
                    'placeholder' => __('Email'),
                    'value' => auth()->user()->email,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'text',
                    'name' => 'phone_number',
                    'id' => 'phone_number',
                    'label' => __('Phone Number'),
                    'placeholder' => __('Phone Number'),
                    'value' => auth()->user()->phone_number,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'text',
                    'name' => 'address',
                    'id' => 'address',
                    'label' => __('Address'),
                    'placeholder' => __('Address'),
                    'value' => auth()->user()->address,
                    'errors' => $errors,])
                @endcomponent

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}
                </button>
                <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> {{ __('Reset') }}
                </button>
            </form>
        </div>
    </div>
@endsection
