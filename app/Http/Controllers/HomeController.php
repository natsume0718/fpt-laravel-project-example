<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Models\Product;

class HomeController extends AbstractController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')
            ->where('name', 'like', '%' . \Request::get('s', '') . '%')
            ->paginate(\Request::get('per_page', 4));

        return view('home', [
            'products' => $products,
        ]);
    }
}
