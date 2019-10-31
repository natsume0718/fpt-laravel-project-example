<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\OrderStoreRequest;
use App\Models\Order;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class OrderController extends AbstractCRUDController
{
    public const VIEW_ALIAS = 'admin.orders';
    public const ROUTE_ALIAS = 'admin.orders';

    protected function model()
    {
        $this->model = new Order();
    }

    protected function indexRequestClassName()
    {
        return IndexRequest::class;
    }

    protected function storeRequestClassName()
    {
        return OrderStoreRequest::class;
    }

    protected function updateRequestClassName()
    {
        return OrderStoreRequest::class;
    }

    protected function bulkRequestClassName()
    {
        return BulkRequest::class;
    }
}
