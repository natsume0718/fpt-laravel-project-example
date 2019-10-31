<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Http\Request\Admin\Comments\StoreRequest;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductCategory;

class CommentController extends AbstractController
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $isCreated = Comment::create($request->all());

        if (!$isCreated) {
            return redirect()->back()->with('error', __('Not Saved!'));
        }

        return redirect()->back()->with('success', __('Saved!'));
    }
}
