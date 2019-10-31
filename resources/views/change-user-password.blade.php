@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Change Password</h5>
        <div class="card-body">
            @include('includes.error-alert')
            @include('includes.success-alert')

            <form method="post" action="{{ route('user.edit-password') }}">
                @csrf
                @method('PUT')
                @component('components.input', [
                    'type' => 'text',
                    'name' => 'password',
                    'id' => 'password',
                    'label' => __('New Password'),
                    'placeholder' => __('Password'),
                    'value' => old('password'),
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
