<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use Illuminate\Http\Request;

abstract class AbstractCRUDController extends AbstractController
{
    protected $model;

    public function __construct()
    {
        $this->model();
        $this->indexRequestClassName();
        $this->storeRequestClassName();
        $this->updateRequestClassName();
        $this->bulkRequestClassName();
    }

    abstract protected function model();

    abstract protected function indexRequestClassName();

    abstract protected function storeRequestClassName();

    abstract protected function updateRequestClassName();

    abstract protected function bulkRequestClassName();

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $request = $this->makeRequestModel($this->indexRequestClassName());

        $models = $this->model::orderBy($request->get('sort_field', 'id'), $request->get('sort_order', 'desc'));

        foreach ($request->get('search', []) as $column => $value) {
            $models->where($column, 'like', '%' . $value . '%');
        }

        $models = $models->paginate($request->get('per_page', 10));

        return view($this->getViewName(static::INDEX), compact('models'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function create()
    {
        return view($this->getViewName(static::CREATE));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store()
    {
        $request = $this->makeRequestModel($this->storeRequestClassName());

        $isCreated = $this->model::create($request->all());

        $redirectRouteName = $this->getRouteName(static::INDEX);

        if (!$isCreated) {
            return redirect(route($redirectRouteName))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName))->with('success', __('Saved!'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $model = $this->model::findOrFail($id);

        return view($this->getViewName(static::SHOW), compact('model'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $model = $this->model::findOrFail($id);

        return view($this->getViewName(static::EDIT), compact('model'));
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

        $isUpdated = $model->update($request->all());

        $redirectRouteName = $this->getRouteName(static::EDIT);

        if (!$isUpdated) {
            return redirect(route($redirectRouteName, $id))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName, $id))->with('success', __('Saved!'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $model = $this->model::findOrFail($id);

        $isDeleted = $model->delete();

        $redirectRouteName = $this->getRouteName(static::INDEX);

        if (!$isDeleted) {
            return redirect(route($redirectRouteName))->with('error', __('Not Deleted!'));
        }

        return redirect(route($redirectRouteName))->with('success', __('Deleted!'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function bulk()
    {
        $request = $this->makeRequestModel($this->bulkRequestClassName());

        $action = $request->post('action');
        $ids = $request->post('ids');
        $message = '';

        switch ($action) {
            case 'delete':
                $this->model::destroy($ids);
                $message = __('Deleted!');
                break;
        }

        $redirectRouteName = $this->getRouteName(static::INDEX);

        return redirect(route($redirectRouteName))->with('success', $message);
    }

    /**
     * @param string $requestClassName
     * @return mixed
     * @throws \Exception
     */
    private function makeRequestModel(string $requestClassName)
    {
        $model = \App::make($requestClassName);

        if (!$model instanceof Request) {
            throw new \Exception("Class {$requestClassName} must be an instance of Illuminate\\Http\\Request");
        }

        return $model;
    }
}
