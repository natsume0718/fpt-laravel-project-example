@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ __('Product') }}: {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('Product') }} {{ __('Information') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <a class="btn btn-primary" href="{{ route('admin.products.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create New') }}</a>
                <a class="btn btn-success" href="{{ route('admin.products.edit', $model->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> {{ __('Edit') }}</a>
                <form action="{{ route('admin.products.destroy', $model->id) }}"
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
                    <tr>
                        <td>{{ __('Content') }}</td>
                        <td>{{ $model->content }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Price') }}</td>
                        <td>{{ $model->price }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td>{{ $model->discount }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('View') }}</td>
                        <td>{{ $model->view }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Status') }}</td>
                        <td>{{ $model->status }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Created At') }}</td>
                        <td>{{ $model->created_at }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Updated At') }}</td>
                        <td>{{ $model->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>

            @endcomponent

        </div>
    </div>
@endsection
