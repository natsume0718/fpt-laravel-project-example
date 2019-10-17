<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AbstractController;
use App\Http\Request\Admin\Users\IndexUserRequest as IndexRequest;
use App\Models\User as Model;
use App\Http\Request\Admin\Users\CreateUserRequest as CreateRequest;
use App\Http\Request\Admin\Users\StoreUserRequest as StoreRequest;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class UserController extends AbstractController
{
    public const VIEW_ALIAS = 'admin.users';
    public const ROUTE_ALIAS = 'admin.users';

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param IndexRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IndexRequest $request)
    {
        $models = $this->model::orderBy($request->get('sort_field', 'id'), 'desc');

        foreach ($request->get('search', []) as $column => $value) {
            $models->where($column, 'like', '%' . $value . '%');
        }

        $models = $models->paginate($request->get('per_page', 10));

        return view($this->getViewName(static::INDEX), compact('models'));
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CreateRequest $request)
    {
        return view($this->getViewName(static::CREATE));
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request)
    {
//        $isCreated = $this->repository->create($request->all());
//
        $redirectRouteName = $this->getRouteName(static::INDEX);
//
//        if (!$isCreated) {
//            return redirect(route($redirectRouteName))->with('error', __('Not Saved!'));
//        }

        return redirect(route($redirectRouteName))->with('success', __('Saved!'));
    }
//
//    /**
//     * @param ShowRequest $request
//     * @param int $id
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     * @throws \App\Base\Controllers\Exceptions\ControllerException
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function show(ShowRequest $request, int $id)
//    {
//        $this->ifNotSetRepositoryThrowException();
//
//        $model = $this->repository->findOneOrFail($id);
//
////        $this->authorize($this->policy::ABILITY_VIEW, $model);
//
//        return view($this->getViewName(static::SHOW), compact('model'));
//    }
//
//    /**
//     * @param EditRequest $request
//     * @param int $id
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     * @throws \App\Base\Controllers\Exceptions\ControllerException
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function edit(EditRequest $request, int $id)
//    {
//        $this->ifNotSetRepositoryThrowException();
//
//        $model = $this->repository->findOneOrFail($id);
//
////        $this->authorize($this->policy::ABILITY_UPDATE, $model);
//
//        return view($this->getViewName(static::EDIT), compact('model'));
//    }
//
//    /**
//     * @param UpdateRequest $request
//     * @param int $id
//     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
//     * @throws \App\Base\Controllers\Exceptions\ControllerException
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function update(UpdateRequest $request, int $id)
//    {
//        $this->ifNotSetRepositoryThrowException();
//
//        $model = $this->repository->findOneOrFail($id);
//
////        $this->authorize($this->policy::ABILITY_UPDATE, $model);
//
//        $isUpdated = $this->repository->update($model, $request->all());
//
//        $redirectRouteName = $this->getRouteName(static::EDIT);
//
//        if (!$isUpdated) {
//            return redirect(route($redirectRouteName, $id))->with('error', __('Not Saved!'));
//        }
//
//        return redirect(route($redirectRouteName, $id))->with('success', __('Saved!'));
//    }
//
//    /**
//     * @param DestroyRequest $request
//     * @param int $id
//     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
//     * @throws \App\Base\Controllers\Exceptions\ControllerException
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function destroy(DestroyRequest $request, int $id)
//    {
//        $this->ifNotSetRepositoryThrowException();
//
//        $this->repository->findOneOrFail($id);
//
////        $this->authorize($this->policy::ABILITY_DELETE, $model);
//
//        $isDeleted = $this->repository->deleteById($id);
//
//        $redirectRouteName = $this->getRouteName(static::INDEX);
//
//        if (!$isDeleted) {
//            return redirect(route($redirectRouteName))->with('error', __('Not Deleted!'));
//        }
//
//        return redirect(route($redirectRouteName))->with('success', __('Deleted!'));
//    }
//
//    /**
//     * @param BulkRequest $request
//     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
//     * @throws \App\Base\Controllers\Exceptions\ControllerException
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function bulk(BulkRequest $request)
//    {
////        $this->authorize($this->policy::ABILITY_BULK, $this->entity);
//
//        $this->ifNotSetRepositoryThrowException();
//
//        $action = $request->post('action');
//        $ids = $request->post('ids');
//        $message = '';
//
//        switch ($action) {
//            case 'delete':
//                $this->repository->destroy($ids);
//                $message = __('Deleted!');
//                break;
//        }
//
//        $redirectRouteName = $this->getRouteName(static::INDEX);
//
//        return redirect(route($redirectRouteName))->with('success', $message);
//    }
}
