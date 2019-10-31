@extends('layouts.app')

@section('content')
    <div class="card" style="margin-bottom: 20px">
        <div class="card-header">
            {{ $model->name }}
        </div>
        <div class="card-body">
            <div style="padding: 20px; text-align: center">
                <img src="{{ $model->feature_image }}">
            </div>
            <hr>
            <h5 class="card-title">{{ $model->name }}</h5>
            <p class="card-text">{{ $model->content }}</p>
            <form action="{{ route('carts.add-item') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $model->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus"></i> Add to card</button>
            </form>
        </div>
        <div class="card-footer text-muted">
            {{ $model->created_at}}
        </div>
    </div>

    <div class="card" style="margin-bottom: 20px">
        <div class="card-header">
            {{ __('Comments') }}
        </div>
        <div class="card-body">
            @guest
                <h5>Please, login to comment for this product</h5>
            @else
                @include('includes.error-alert')
                @include('includes.success-alert')
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $model->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="status" value="1">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-10">
                                <input name="content" class="form-control" placeholder="Your comment content ...">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary" style="width: 100%">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endguest
            <?php
            $comments = \App\Models\Comment::where('product_id', $model->id)
                ->where('status', 1)
                ->paginate(5);
            ?>
            @foreach($comments as $comment)
                <div class="card" style="margin-bottom: 10px">
                    <div class="card-body">
                        <h5 class="card-title">{{ '@' . $comment->user->name }}</h5>
                        <p class="card-text">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
            {!! $comments->links() !!}
        </div>
    </div>
    <?php
    $products = \App\Models\Product::limit(2)->inRandomOrder()->get();
    ?>
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
    </div>
@endsection
