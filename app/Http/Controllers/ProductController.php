<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Models\Product;

class ProductController extends AbstractController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $model = Product::findOrFail($id);

        return view('products.show', compact('model'));
    }
}
