@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create') . ' ' .  __('Product') }}
                @endslot

                @slot('card_footer')
                    {{ __('Input your data') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="post" action="{{ route('admin.products.store') }}">
                    @csrf
                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'name',
                        'id' => 'name',
                        'label' => __('Name'),
                        'placeholder' => __('Name'),
                        'value' => old('name'),
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'content',
                        'id' => 'content',
                        'label' => __('Content'),
                        'placeholder' => __('Content'),
                        'value' => old('content'),
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'number',
                        'name' => 'price',
                        'id' => 'price',
                        'label' => __('Price'),
                        'placeholder' => __('Price'),
                        'value' => old('price'),
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'number',
                        'name' => 'discount',
                        'id' => 'discount',
                        'label' => __('Discount'),
                        'placeholder' => __('Discount'),
                        'value' => old('discount'),
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.select', [
                        'name' => 'status',
                        'id' => 'status',
                        'label' => __('Status'),
                        'data' => [
                            'Pending' => 0,
                            'Public' => 1
                        ],
                        'selected' => old('status'),
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.select', [
                        'name' => 'user_id',
                        'id' => 'user_id',
                        'label' => __('Author'),
                        'data' => $usersData,
                        'selected' => old('user_id'),
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
