@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Carts</h5>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $totalPrice = 0;
                ?>
                @foreach($models as $model)
                    <tr>
                        <td><img src="{{ $model->product->feature_image }}" alt="" style="max-width: 50px"></td>
                        <td>{{ $model->product->name }}</td>
                        <td>$ {{ number_format($model->product->price) }}</td>
                        <td>{{ $model->quantity }}</td>
                        <td>$ {{ number_format($totalPrice += $model->product->price * $model->quantity) }}</td>
                        <td>
                            <form action="{{ route('carts.destroy', $model->id) }}" method="post"
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
                <tr>
                    <td colspan="3"></td>
                    <td colspan="1"><strong>Total Price:</strong></td>
                    <td>$ {{ number_format($totalPrice) }}</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            @if (count($models) > 0)
                <a href="{{ route('orders.create') }}" class="btn btn-primary" style="width: 100%">Order Now</a>
            @endif
        </div>
    </div>
@endsection
