<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\Admin\Products\UpdateRequest;
use App\Http\Request\Admin\Products\StoreRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Arr;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class ProductController extends AbstractCRUDController
{
    public const VIEW_ALIAS = 'admin.products';
    public const ROUTE_ALIAS = 'admin.products';

    protected function model()
    {
        $this->model = new Product();
    }

    protected function indexRequestClassName()
    {
        return IndexRequest::class;
    }

    protected function storeRequestClassName()
    {
        return StoreRequest::class;
    }

    protected function updateRequestClassName()
    {
        return UpdateRequest::class;
    }

    protected function bulkRequestClassName()
    {
        return BulkRequest::class;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function create()
    {
        $usersData = Arr::pluck(User::all(['id', 'username'])->toArray(), 'id', 'username');
        $productCategoriesData = Arr::pluck(ProductCategory::all(['id', 'name'])->toArray(), 'id', 'name');
        return view($this->getViewName(static::CREATE), [
            'productCategoriesData' => $productCategoriesData,
            'usersData' => $usersData
        ]);
    }
}
