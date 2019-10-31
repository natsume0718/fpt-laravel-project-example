<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store()
    {
//        $request = $this->makeRequestModel($this->storeRequestClassName());
//
//        $isCreated = $this->model::create($request->all());
//
//        $redirectRouteName = $this->getRouteName(static::INDEX);
//
//        if (!$isCreated) {
//            return redirect(route($redirectRouteName))->with('error', __('Not Saved!'));
//        }
//
//        return redirect(route($redirectRouteName))->with('success', __('Saved!'));
    }
}
