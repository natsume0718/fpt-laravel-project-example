@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    <a href="{{ route('admin.products.index') }}">
                        <i class="fa fa-list" aria-hidden="true"></i> {{ __('All') }} {{ __('Orders') }}
                    </a>
                @endslot

                @slot('card_footer')
                    {{ __('All') }} {{ __('Orders') }}: {{ count($models) }} {{ __('items') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="get" action="{{ route('admin.orders.index') }}" id="filter-form">
                </form>
                <form method="post" action="{{ route('admin.orders.bulk') }}" id="bulk-form"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                </form>
                <div class="row">
                    <div class="col-8">
{{--                        <a class="btn btn-primary" href="{{ route('admin.products.create') }}"><i--}}
{{--                                class="fas fa-plus-square"></i>--}}
{{--                            {{ __('Create New') }} {{ __('Product') }}</a>--}}
                    </div>
                    <div class="col-4">
                        <div class="form-row justify-content-end">
                            <div class="col-auto">
                                <select class="form-control" id="bulkAction" name="per_page" form="filter-form"
                                        onchange='this.form.submit()'>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                                        10 {{ __('items per page') }}</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>
                                        20 {{ __('items per page') }}</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>
                                        30 {{ __('items per page') }}</option>
                                    <option value="40" {{ request('per_page') == 40 ? 'selected' : '' }}>
                                        40 {{ __('items per page') }}</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                        50 {{ __('items per page') }}</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary"
                                        form="filter-form">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                @component('components.table')

                    @slot('head')
                        <tr>
                            <th scope="col">
                                <div class="form-group">
                                    <input type="checkbox">
                                </div>
                            </th>
                            <th scope="col" style="width: 80px;">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'id',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">#{{ __('Id') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="number" class="form-control" placeholder="ID" name="search[id]"
                                           form="filter-form"
                                           value="{{ request('search')['id'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'user_id',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('User') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="text" class="form-control" placeholder="Name" name="search[user_id]"
                                           form="filter-form"
                                           value="{{ request('search')['user_id'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'customer_phone_number',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('Customer Phone Number') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="number" class="form-control" placeholder="Price" name="search[customer_phone_number]"
                                           form="filter-form"
                                           value="{{ request('search')['customer_phone_number'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'customer_address',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('Customer Address') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="number" class="form-control" placeholder="Price" name="search[customer_address]"
                                           form="filter-form"
                                           value="{{ request('search')['customer_address'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'status',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('Status') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="number" class="form-control" placeholder="Status" name="search[status]"
                                           form="filter-form"
                                           value="{{ request('search')['status'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col" style="width: 160px">
                                <div class="form-group">
                                    <label>Action</label>
                                    <br>
                                    <button type="submit" class="btn btn-primary" form="filter-form"><i
                                            class="fas fa-filter"></i>
                                    </button>
                                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </th>
                        </tr>
                    @endslot

                    @slot('body')
                        @foreach($models as $model)
                            <tr>
                                <th scope="row" class="align-middle">
                                    <input type="checkbox" value="{{ $model->id }}" name="ids[]" form="bulk-form">
                                </th>
                                <th class="align-middle">{{ $model->id }}</th>
                                <td class="align-middle">{{ $model->user->username }}</td>
                                <td class="align-middle">{{ $model->customer_phone_number }}</td>
                                <td class="align-middle">{{ $model->customer_address }}</td>
                                <td class="align-middle">{{ ($model->status == 0) ? 'Pending' : 'Approve' }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.orders.edit', $model->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                                    <a href="{{ route('admin.orders.show', $model->id) }}"
                                       class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>

                                    <form action="{{ route('admin.orders.destroy', $model->id) }}" method="post"
                                          class="d-inline-block"
                                          onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endslot

                @endcomponent

                {!! $models->links() !!}

                <div class="form-row">
                    <div class="col-auto">
                        <select class="form-control" id="bulkAction" name="action" form="bulk-form">
                            <option value="">{{ __('Choose') }} {{ __('Action') }}</option>
                            <option value="delete">{{ __('Delete') }}</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" form="bulk-form">{{ __('Submit') }}</button>
                    </div>
                </div>

            @endcomponent

        </div>
    </div>
@endsection
