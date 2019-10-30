<?php

namespace App\Http\Controllers\Admin\Comments;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\Admin\Comments\UpdateRequest;
use App\Http\Request\Admin\Comments\StoreRequest;
use App\Models\Comment;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class CommentController extends AbstractCRUDController
{
    public const VIEW_ALIAS = 'admin.comments';
    public const ROUTE_ALIAS = 'admin.comments';

    protected function model()
    {
        $this->model = new Comment();
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
