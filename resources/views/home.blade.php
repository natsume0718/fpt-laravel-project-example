@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
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
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card" style="margin-bottom: 20px">
                    <div class="card-header">Account</div>
                    <div class="card-body">
                        @guest
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success"
                                        name="btn_login">{{ __('Login') }}</button>
                            </form>
                        @else
                            <h5>{{ '@'. auth()->user()->name }}</h5>
                        @endguest
                    </div>
                    <ul class="list-group list-group-flush">
                        @guest
                            <li class="list-group-item"><a href="{{ route('register') }}" class="text-primary">Forget
                                    Password?</a></li>
                            <li class="list-group-item"><a href="{{ route('register') }}"
                                                           class="text-primary">Register</a></li>
                        @else
                            <li class="list-group-item"><a href="{{ route('register') }}"
                                                           class="text-primary">Logout</a></li>
                            <li class="list-group-item"><a href="{{ route('register') }}"
                                                           class="text-primary">Change Information</a></li>
                            <li class="list-group-item"><a href="{{ route('register') }}"
                                                           class="text-primary">Change Password</a></li>
                        @endguest
                    </ul>
                </div>
                <div class="card" style="margin-bottom: 20px">
                    <div class="card-header">
                        Product Categories
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $productCategories = \App\Models\ProductCategory::orderBy('id', 'DESC')
                            ->get();
                        ?>
                        @foreach($productCategories as $productCategory)
                            <li class="list-group-item"><a
                                    href="{{ route('products.indexByCategory', ['id' =>$productCategory->id]) }}">{{ $productCategory->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="card-footer text-muted">
                        <form action="/site/hang-hoa/liet-ke.php">
                            @csrf
                            <input class="form-control" name="keywords" type="text"
                                   placeholder="Search Everything in here">
                        </form>
                    </div>
                </div>
                <div class="card" style="margin-bottom: 20px">
                    <div class="card-header">
                        Top 10 Products
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $top10Products = \App\Models\Product::orderBy('view', 'DESC')
                            ->limit(10)
                            ->get();
                        ?>
                        @for ($i = 0; $i < 10; $i++)
                            <li class="list-group-item"><a href="">{{ $top10Products[$i]->name }}</a></li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
