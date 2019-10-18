@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    {{ __('User') }}: {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('User') }} {{ __('Information') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <a class="btn btn-primary" href="{{ route('admin.users.create') }}">{{ __('Create New') }}</a>
                <a class="btn btn-success" href="{{ route('admin.users.edit', $model->id) }}">{{ __('Edit') }}</a>
                <form action="{{ route('admin.users.destroy', $model->id) }}"
                      method="post"
                      class="d-inline-block"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
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
                        <td>{{ __('Email') }}</td>
                        <td>{{ $model->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Username') }}</td>
                        <td>{{ $model->username }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Phone Number') }}</td>
                        <td>{{ $model->phone_number }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Address') }}</td>
                        <td>{{ $model->address }}</td>
                    </tr>
                    </tbody>
                </table>

            @endcomponent

        </div>
    </div>
@endsection
