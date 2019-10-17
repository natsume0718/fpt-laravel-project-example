<?php

namespace App\Http\Controllers\Admin\Users;

use App\Common\Users\Entities\UserEntity as Entity;
use App\Common\Users\Models\User as Model;
use App\Common\Users\Repositories\Interfaces\UserRepositoryInterface as Repository;
use App\Http\Controllers\AbstractController;
use App\Common\Users\Requests\IndexUserRequest as IndexRequest;
use App\Common\Users\Requests\CreateUserRequest as CreateRequest;
use App\Common\Users\Requests\StoreUserRequest as StoreRequest;
use App\Common\Users\Requests\ShowUserRequest as ShowRequest;
use App\Common\Users\Requests\EditUserRequest as EditRequest;
use App\Common\Users\Requests\UpdateUserRequest as UpdateRequest;
use App\Common\Users\Requests\DestroyUserRequest as DestroyRequest;
use App\Common\Users\Requests\BulkUserRequest as BulkRequest;
use App\Models\User;
use App\Policies\Admin\Users\UserPolicy as Policy;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Users
 */
class UserController extends AbstractController
{
    public const VIEW_ALIAS = 'admin.users';
    public const ROUTE_ALIAS = 'admin.users';

    protected $model;
    protected $entity;
    protected $repository;
    protected $policy;

    /**
     * UserController constructor.
     * @param Repository $repository
     * @param Policy $policy
     * @param Entity $entity
     * @param Model $model
     */
    public function __construct(Repository $repository, Policy $policy, Entity $entity, Model $model)
    {
        $this->policy = $policy;
        $this->entity = $entity;
        $this->model = $model;
        $this->repository = $repository;
    }


    /**
     * @param IndexRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(IndexRequest $request)
    {
//        $this->authorize($this->policy::ABILITY_VIEW_ANY, $this->entity);

        $this->ifNotSetRepositoryThrowException();

        $models = $this->repository
            ->orderBy($request->get('sort_field', 'id'), $request->get('sort_order', 'desc'))
            ->search($request->get('search', []))
            ->paginate($request->get('per_page', 10));

        return view($this->getViewName(static::INDEX), compact('models'));
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(CreateRequest $request)
    {
        $this->authorize($this->policy::ABILITY_CREATE, $this->entity);

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
        $this->authorize($this->policy::ABILITY_CREATE, $this->entity);

        $this->ifNotSetRepositoryThrowException();

        $isCreated = $this->repository->create($request->all());

        $redirectRouteName = $this->getRouteName(static::INDEX);

        if (!$isCreated) {
            return redirect(route($redirectRouteName))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName))->with('success', __('Saved!'));
    }

    /**
     * @param ShowRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(ShowRequest $request, int $id)
    {
        $this->ifNotSetRepositoryThrowException();

        $model = $this->repository->findOneOrFail($id);

        $this->authorize($this->policy::ABILITY_VIEW, $model);

        return view($this->getViewName(static::SHOW), compact('model'));
    }

    /**
     * @param EditRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(EditRequest $request, int $id)
    {
        $this->ifNotSetRepositoryThrowException();

        $model = $this->repository->findOneOrFail($id);

        $this->authorize($this->policy::ABILITY_UPDATE, $model);

        return view($this->getViewName(static::EDIT), compact('model'));
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, int $id)
    {
        $this->ifNotSetRepositoryThrowException();

        $model = $this->repository->findOneOrFail($id);

        $this->authorize($this->policy::ABILITY_UPDATE, $model);

        $isUpdated = $this->repository->update($model, $request->all());

        $redirectRouteName = $this->getRouteName(static::EDIT);

        if (!$isUpdated) {
            return redirect(route($redirectRouteName, $id))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirectRouteName, $id))->with('success', __('Saved!'));
    }

    /**
     * @param DestroyRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyRequest $request, int $id)
    {
        $this->ifNotSetRepositoryThrowException();

        $model = $this->repository->findOneOrFail($id);

        $this->authorize($this->policy::ABILITY_DELETE, $model);

        $isDeleted = $this->repository->deleteById($id);

        $redirectRouteName = $this->getRouteName(static::INDEX);

        if (!$isDeleted) {
            return redirect(route($redirectRouteName))->with('error', __('Not Deleted!'));
        }

        return redirect(route($redirectRouteName))->with('success', __('Deleted!'));
    }

    /**
     * @param BulkRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Base\Controllers\Exceptions\ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bulk(BulkRequest $request)
    {
        $this->authorize($this->policy::ABILITY_BULK, $this->entity);

        $this->ifNotSetRepositoryThrowException();

        $action = $request->post('action');
        $ids = $request->post('ids');
        $message = '';

        switch ($action) {
            case 'delete':
                $this->repository->destroy($ids);
                $message = __('Deleted!');
                break;
        }

        $redirectRouteName = $this->getRouteName(static::INDEX);

        return redirect(route($redirectRouteName))->with('success', $message);
    }
}
