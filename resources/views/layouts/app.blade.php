<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('dist/main.css') }}" type="text/css"/>

    <script src="{{ asset('dist/bundle.js') }}" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Shop') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ __('Home') }}
                    <span
                        class="sr-only">(current)</span></a>
            </li>
            <?php $productCategories = \App\Models\ProductCategory::limit(6)->orderBy('id', 'DESC')->get();?>
            @foreach($productCategories as $productCategory)
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('products.indexByCategory', ['id' =>$productCategory->id]) }}"></i> {{ $productCategory->name }}</a>
                </li>
            @endforeach
            <li class="nav-item">
                <a class="nav-link"
                   href="{{ route('about') }}"></i>About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="{{ route('contact') }}"></i>Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="{{ route('discuss') }}"></i>Discuss</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="{{ route('faq') }}"></i>FAQ</a>
            </li>
            <li class="nav-item">
                @guest
                    <?php $totalCartItems = 0; ?>
                @else
                    <?php
                    $totalCartItems = \App\Models\Cart::where('user_id', auth()->user()->id)->count();
                    ?>
                @endguest
                <a class="nav-link"
                   href="{{ route('carts.index') }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    ({{$totalCartItems}}) Cart</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('home') }}">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                   name="s"
                   value="{{ request('s') }}"
                   onchange='this.form.submit()'>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{ __('Search') }}</button>
        </form>
    </div>
</nav>

<div class="container main-content mt-3">
    <div class="row">
        <div class="col-12 col-lg-8">
            @yield('content')
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                        <li class="list-group-item">
                            <a class="text-primary" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
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
                    <form action="{{ route('home') }}">
                        @csrf
                        <input class="form-control" type="text"
                               name="s"
                               value="{{ request('s') }}"
                               onchange='this.form.submit()'
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
                        <li class="list-group-item"><a href="{{ route('products.show', ['id' => $top10Products[$i]->id]) }}">{{ $top10Products[$i]->name }}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
