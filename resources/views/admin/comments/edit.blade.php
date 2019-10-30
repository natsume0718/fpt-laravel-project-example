@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">
            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('Update') . ' ' .  __('Product') }}: {{ $model->id }}
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
                        'name' => 'content',
                        'id' => 'content',
                        'label' => __('Content'),
                        'placeholder' => __('Content'),
                        'value' => $model->content,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'number',
                        'name' => 'price',
                        'id' => 'price',
                        'label' => __('Price'),
                        'placeholder' => __('Price'),
                        'value' => $model->price,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'number',
                        'name' => 'discount',
                        'id' => 'discount',
                        'label' => __('Discount'),
                        'placeholder' => __('Discount'),
                        'value' => $model->discount,
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
                        'selected' => $model->status,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.select', [
                        'name' => 'user_id',
                        'id' => 'user_id',
                        'label' => __('Author'),
                        'data' => $usersData,
                        'selected' => $model->user_id,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'created_at',
                        'id' => 'created_at',
                        'label' => __('Created At'),
                        'placeholder' => __('Created At'),
                        'readonly' => true,
                        'value' => $model->created_at,
                        'errors' => $errors,])
                    @endcomponent

                    @component('components.input', [
                        'type' => 'text',
                        'name' => 'updated_at',
                        'id' => 'updated_at',
                        'label' => __('Updated At'),
                        'placeholder' => __('Updated At'),
                        'readonly' => true,
                        'value' => $model->updated_at,
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
