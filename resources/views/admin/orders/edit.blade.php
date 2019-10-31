@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('Update') . ' ' .  __('Order') }}: {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('Input your data') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="post" action="{{ route('admin.orders.update', $model->id) }}">
                    @csrf
                    @method('PUT')
                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'customer_phone_number',
                        'id' => 'customer_phone_number',
                        'label' => __('Customer Phone Number'),
                        'placeholder' => __('Customer Phone Number'),
                        'value' => $model->customer_phone_number,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'customer_address',
                        'id' => 'customer_address',
                        'label' => __('Customer Address'),
                        'placeholder' => __('Customer Address'),
                        'value' => $model->customer_address,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'note',
                        'id' => 'note',
                        'label' => __('Note'),
                        'placeholder' => __('Note'),
                        'value' => $model->note,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.select', [
                        'name' => 'status',
                        'id' => 'status',
                        'label' => __('Status'),
                        'data' => [
                            'Pending' => 0,
                            'Approve' => 1
                        ],
                        'selected' => $model->status,
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
