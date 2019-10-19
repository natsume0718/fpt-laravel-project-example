<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\Users\BulkUserRequest;
use App\Http\Request\Admin\Users\IndexUserRequest;
use App\Http\Request\Admin\Users\UpdateUserRequest;
use App\Models\Product;
use App\Http\Request\Admin\Users\StoreUserRequest;

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
        $this->indexRequestClassName = IndexUserRequest::class;
    }

    protected function storeRequestClassName()
    {
        $this->storeRequestClassName = StoreUserRequest::class;
    }

    protected function updateRequestClassName()
    {
        $this->updateRequestClassName = UpdateUserRequest::class;
    }

    protected function bulkRequestClassName()
    {
        $this->updateRequestClassName = BulkUserRequest::class;
    }
}
