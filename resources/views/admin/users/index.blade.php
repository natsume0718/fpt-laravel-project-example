@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    <a href="{{ route('admin.users.index') }}">{{ __('All') }} {{ __('Users') }}</a>
                @endslot

                @slot('card_footer')
                    {{ __('All') }} {{ __('Users') }}: {{ count($models) }} {{ __('items') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                <form method="get" action="{{ route('admin.users.index') }}" id="filter-form">
                </form>
                <form method="post" action="{{ route('admin.users.bulk') }}" id="bulk-form"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                </form>
                <div class="row">
                    <div class="col-8">
                        @can('create', 'App\Common\Users\Entities\UserEntity')
                            <a class="btn btn-primary" href="{{ route('admin.users.create') }}"><i
                                    class="fas fa-plus-square"></i>
                                {{ __('Create New') }}</a>
                        @endcan
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
                            <th scope="col" style="width: 100px;">
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
                                                'sort_field' => 'name',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('Name') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="text" class="form-control" placeholder="Name" name="search[name]"
                                           form="filter-form"
                                           value="{{ request('search')['name'] }}"
                                           onchange='this.form.submit()'>
                                </div>
                            </th>
                            <th scope="col">
                                <div class="form-group">
                                    <label><a
                                            href="{{ request()->fullUrlWithQuery([
                                                'sort_field' => 'email',
                                                'sort_order' => request('sort_order') == 'desc' ? 'asc' : 'desc'
                                            ]) }}">{{ __('Email') }}</a>
                                        <i class="fas fa-sort"></i></label>
                                    <input type="email" class="form-control" placeholder="Email" name="search[email]"
                                           form="filter-form"
                                           value="{{ request('search')['email'] }}"
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
                                <td class="align-middle">{{ $model->name }}</td>
                                <td class="align-middle">{{ $model->email }}</td>
                                <td class="align-middle">
                                    @can('update', $model)
                                        <a href="{{ route('admin.users.edit', ['id' => $model->id]) }}"
                                           class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    @can('view', $model)
                                        <a href="{{ route('admin.users.show', ['id' => $model->id]) }}"
                                           class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan

                                    @can('delete', $model)
                                        <form action="{{ route('admin.users.destroy', $model->id) }}" method="post"
                                              class="d-inline-block"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endslot

                @endcomponent

                {!! $models->links() !!}

                @can('bulk', 'App\Common\Users\Entities\UserEntity')
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
                @endcan

            @endcomponent

        </div>
    </div>
@endsection
