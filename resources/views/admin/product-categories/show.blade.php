@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ __('Product Category') }} : {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('Product Category') }} {{ __('Information') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <a class="btn btn-primary" href="{{ route('admin.product-categories.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create New') }}</a>
                <a class="btn btn-success" href="{{ route('admin.product-categories.edit', $model->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> {{ __('Edit') }}</a>
                <form action="{{ route('admin.product-categories.destroy', $model->id) }}"
                      method="post"
                      class="d-inline-block"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> {{ __('Delete') }}</button>
                </form>
                <table class="table table-striped table-bordered table-hover mt-3">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('Attribute') }}</th>
                        <th scope="col">{{ __('Value') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ __('ID') }}</td>
                        <td>{{ $model->id }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Name') }}</td>
                        <td>{{ $model->name }}</td>
                    </tr>
                    </tbody>
                </table>

            @endcomponent

        </div>
    </div>
@endsection
