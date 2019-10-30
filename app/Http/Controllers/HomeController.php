<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Models\Product;
use App\Models\ProductCategory;

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
            ->paginate(\Request::get('per_page', 4));
        $top10Products = Product::orderBy('view', 'DESC')
            ->limit(10)
            ->get();
        $productCategories = ProductCategory::orderBy('id', 'DESC')
            ->get();

        return view('home', [
            'products' => $products,
            'productCategories' => $productCategories,
            'top10Products' => $top10Products
        ]);
    }
}
