<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\Admin\ProductCategories\UpdateRequest;
use App\Http\Request\Admin\ProductCategories\StoreRequest;
use App\Models\ProductCategory;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class ProductCategoryController extends AbstractCRUDController
{
    public const VIEW_ALIAS = 'admin.product-categories';
    public const ROUTE_ALIAS = 'admin.product-categories';

    protected function model()
    {
        $this->model = new ProductCategory();
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
}
