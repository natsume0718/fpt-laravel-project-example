@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Create Order</h5>
        <div class="card-body">
            @include('includes.error-alert')
            @include('includes.success-alert')

            <form method="post" action="{{ route('orders.store') }}">
                @csrf
                @component('components.input', [
                    'type' => 'text',
                    'name' => 'customer_phone_number',
                    'id' => 'customer_phone_number',
                    'label' => __('Phone Number'),
                    'placeholder' => __('Phone Number'),
                    'value' => auth()->user()->phone_number,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'text',
                    'name' => 'customer_address',
                    'id' => 'customer_address',
                    'label' => __('Address'),
                    'placeholder' => __('Address'),
                    'value' => auth()->user()->address,
                    'errors' => $errors,])
                @endcomponent

                @component('components.input', [
                    'type' => 'text',
                    'name' => 'note',
                    'id' => 'note',
                    'label' => __('Note'),
                    'placeholder' => __('Note'),
                    'value' => old('note'),
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
