<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\Users\BulkUserRequest;
use App\Http\Request\Admin\Users\IndexUserRequest;
use App\Http\Request\Admin\Users\UpdateUserRequest;
use App\Models\User;
use App\Http\Request\Admin\Users\StoreUserRequest;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class UserController extends AbstractCRUDController
{
    public const VIEW_ALIAS = 'admin.users';
    public const ROUTE_ALIAS = 'admin.users';

    protected function model()
    {
        $this->model = new User();
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
