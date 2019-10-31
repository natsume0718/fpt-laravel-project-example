<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\AbstractCRUDController;
use App\Http\Request\Admin\IndexRequest;
use App\Http\Request\Admin\BulkRequest;
use App\Http\Request\Admin\Products\UpdateRequest;
use App\Http\Request\Admin\Products\StoreRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\ImageService;
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

        return view($this->getViewName(static::CREATE), [
            'usersData' => $usersData
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $model = $this->model::findOrFail($id);
        $usersData = Arr::pluck(User::all(['id', 'username'])->toArray(), 'id', 'username');

        return view($this->getViewName(static::EDIT), [
            'model' => $model,
            'usersData' => $usersData
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store()
    {
        $request = $this->makeRequestModel($this->storeRequestClassName());

        $featureImage = '/src/images/default-feature-image.png';
        if ($request->hasFile('file')) {
            $imageService = new ImageService();
            $featureImage = $imageService->storeImage($request->file('file'));
        }

        $isCreated = $this->model::create($request->merge(['feature_image' => $featureImage])->all());

        $redirectRouteName = $this->getRouteName(static::INDEX);

        if (!$isCreated) {
            return redirect(route($redirectRouteName))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName))->with('success', __('Saved!'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(int $id)
    {
        $request = $this->makeRequestModel($this->updateRequestClassName());

        $model = $this->model::findOrFail($id);

        $featureImage = $model->feature_image;
        if ($request->hasFile('file')) {
            $imageService = new ImageService();
            $featureImage = $imageService->storeImage($request->file('file'));
        }

        $isUpdated = $model->update($request->merge(['feature_image' => $featureImage])->all());

        $redirectRouteName = $this->getRouteName(static::EDIT);

        if (!$isUpdated) {
            return redirect(route($redirectRouteName, $id))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName, $id))->with('success', __('Saved!'));
    }
}
