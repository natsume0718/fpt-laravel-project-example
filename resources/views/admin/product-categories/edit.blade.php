@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('Update') . ' ' .  __('Product Category') }} : {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('Input your data') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="post" action="{{ route('admin.product-categories.update', $model->id) }}">
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

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}
                    </button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> {{ __('Reset') }}
                    </button>
                </form>

            @endcomponent
        </div>
    </div>
@endsection
