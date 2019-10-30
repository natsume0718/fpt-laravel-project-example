@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-6">
                <div class="card" style="margin-bottom: 20px">
                    <img class="card-img-top" src="{{ $product->feature_image }}"
                         alt="{{ $product->name }}" style="padding: 20px;">
                    <div class="card-body">
                        <h5 class="card-title"><a
                                href="{{ route('products.show', ['id' => $product->id]) }}"
                                class="text-dark">{{ $product->name }}</a></h5>
                        <p class="card-text">{{ substr($product->content, 0, 200) }}</p>
                        <a href="{{ route('products.show', ['id' => $product->id]) }}"
                           class="btn btn-primary"><i class="far fa-eye"></i> View</a>
                        <a href="#" class="btn btn-success"><i class="fas fa-cart-plus"></i> Add to card</a>
                    </div>
                </div>
            </div>
        @endforeach
        {!! $products->links() !!}
    </div>
@endsection
