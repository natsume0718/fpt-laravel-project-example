@extends('admin.layouts.app')

@section('main')
    <div class="row">
        <div class="col-12">

            @component('components.card')

                @slot('card_header')
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ __('Order') }}: {{ $model->id }}
                @endslot

                @slot('card_footer')
                    {{ __('Order') }} {{ __('Information') }}
                @endslot

                @include('includes.error-alert')
                @include('includes.success-alert')

                {{--                <a class="btn btn-primary" href="{{ route('admin.products.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create New') }}</a>--}}
                <a class="btn btn-success" href="{{ route('admin.orders.edit', $model->id) }}"><i class="fa fa-edit"
                                                                                                  aria-hidden="true"></i> {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.orders.destroy', $model->id) }}"
                      method="post"
                      class="d-inline-block"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                    </button>
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
                        <td>{{ __('Customer Phone Number') }}</td>
                        <td>{{ $model->customer_phone_number }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Customer Address') }}</td>
                        <td>{{ $model->customer_address }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Note') }}</td>
                        <td>{{ $model->note }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Status') }}</td>
                        <td>{{ $model->status == 0 ? 'Pending' : 'Approve' }}</td>
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

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalPrice = 0;
                    ?>
                    @foreach($model->orderItems as $orderItem)
                        <tr>
                            <td><img src="{{ $orderItem->product->feature_image }}" alt="" style="max-width: 50px"></td>
                            <td>{{ $orderItem->product->name }}</td>
                            <td>$ {{ number_format($orderItem->product_unit_price) }}</td>
                            <td>{{ $orderItem->quantity }}</td>
                            <td>$ {{ number_format($totalPrice += $orderItem->product_unit_price * $orderItem->quantity) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="1"><strong>Total Price:</strong></td>
                        <td>$ {{ number_format($totalPrice) }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            @endcomponent

        </div>
    </div>
@endsection
