<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Http\Request\Admin\Comments\StoreRequest;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends AbstractController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $model = Product::findOrFail($id);
        $model->view += 1;
        $model->save();

        return view('products.show', compact('model'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexByCategory(int $id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        $products = Product::where('product_category_id', $productCategory->id)
            ->paginate(\Request::get('per_page', 4));

        return view('home', [
            'products' => $products,
        ]);
    }
}
