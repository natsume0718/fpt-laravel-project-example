<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\Admin\Products\UpdateRequest;
use App\Http\Request\Admin\Products\StoreRequest;
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
        $this->indexRequestClassName = IndexRequest::class;
    }

    protected function storeRequestClassName()
    {
        $this->storeRequestClassName = StoreRequest::class;
    }

    protected function updateRequestClassName()
    {
        $this->updateRequestClassName = UpdateRequest::class;
    }

    protected function bulkRequestClassName()
    {
        $this->updateRequestClassName = BulkRequest::class;
    }
}
