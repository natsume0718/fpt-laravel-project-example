<?php

namespace App\Http\Controllers\Admin\Users;

use App\Base\Controllers\Exceptions\ControllerException;
use App\Common\Users\Entities\UserEntity as Entity;
use App\Common\Users\Models\User as Model;
use App\Common\Users\Repositories\Interfaces\UserRepositoryInterface as Repository;
use App\Http\Controllers\AbstractController;
use Illuminate\Http\Request as Request;
use App\Common\Users\Requests\IndexUserRequest as IndexRequest;
use App\Common\Users\Requests\CreateUserRequest as CreateRequest;
use App\Common\Users\Requests\StoreUserRequest as StoreRequest;
use App\Common\Users\Requests\ShowUserRequest as ShowRequest;
use App\Common\Users\Requests\EditUserRequest as EditRequest;
use App\Common\Users\Requests\UpdateUserRequest as UpdateRequest;
use App\Common\Users\Requests\DestroyUserRequest as DestroyRequest;
use App\Common\Users\Requests\BulkUserRequest as BulkRequest;
use App\Policies\Admin\Users\UserPolicy as Policy;

/**
 * Class UserController
 * -----------------------------------------------------------------------------------------
 * Extends Controller (App\Http\Controllers\Controller)
 *
 * Verb        | URI                        | Action      | Route Name
 * GET         | /admin/users               | index       | admin.users.index
 * GET         | /admin/users/create        | create      | admin.users.create
 * POST        | /admin/users               | store       | admin.users.store
 * GET         | /admin/users/{user}        | show        | admin.users.show
 * GET         | /admin/users/{user}/edit   | edit        | admin.users.edit
 * PUT/PATCH   | /admin/users/{user}        | update      | admin.users.update
 * DELETE      | /admin/users/{user}        | destroy     | admin.users.destroy
 * POST        | /admin/users/bulk          | destroy     | admin.users.bulk
 *
 * -----------------------------------------------------------------------------------------
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
     * Controller constructor.
     * -----------------------------------------------------------------------------------------
     * Injection Repository to var repository
     * Injection Request to var request
     * Injection Policy to var policy
     * Injection Entity to var entity
     * Injection Model to var model
     * -----------------------------------------------------------------------------------------
     *
     * @param Repository $repository
     * @param Request $request
     * @param Policy $policy
     * @param Entity $entity
     * @param Model $model
     */
    public function __construct(Repository $repository, Request $request, Policy $policy, Entity $entity, Model $model)
    {
        $this->policy = $policy;
        $this->entity = $entity;
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * Show index page to listing resources.
     * Default action method for route name index in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection IndexRequest to edit validate rules or something go to Class Named IndexRequest
     *
     * Authorize by Policy if not have permission return HTTP 403 Forbidden.
     *
     * If have permission check this controller is defined var repository by isSetRepository()
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Else get some data need example: sortField, sortBy, perPage ...
     * you can include something data you want
     *
     * Use repository get data to var models
     *
     * Return view, view name get by getViewName function
     * with param name equal with static::INDEX default value is 'index'
     * Set custom your view name by define const INDEX in this controller
     * If your view name is 'example.entity.custom-view define const INDEX by custom-view
     * Or you can remove $this->getViewName(static::CREATE) by what ever view name you want.
     * -----------------------------------------------------------------------------------------
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(IndexRequest $request)
    {
        $this->authorize($this->policy::ABILITY_VIEW_ANY, $this->entity);

        if (!$this->isSetRepository()) {
            throw new ControllerException('$this->>repository must define');
        }

        $sortField = $request->get('sort_field', 'id');
        $sortBy = $request->get('sort_order', 'desc');
        $perPage = $request->get('per_page', 10);
        $searchData = $request->get('search', []);

        $models = $this->repository
            ->orderBy($sortField, $sortBy)
            ->search($searchData)
            ->paginate($perPage);

        return view($this->getViewName(static::INDEX), compact('models'));
    }

    /**
     * Show create page include form for creating a new resource.
     * Default action method for route name create in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection CreateRequest to edit validate rules or something
     * go to Class Named CreateRequest
     *
     * Authorize by Policy if not have permission return HTTP 403 Forbidden.
     *
     * If have permission return view, view name get by getViewName($name)
     * with param name equal with static::CREATE default value is 'create'
     * Set custom your view name by define const CREATE in this controller
     * If your view name is 'example.entity.custom-create define const CREATE by custom-create
     * Or you can remove $this->getViewName(static::CREATE) by what ever view name you want
     * -----------------------------------------------------------------------------------------
     *
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
     * Store a newly created resource in storage.
     * Default action method for route name store in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection StoreRequest to edit validate rules or something go to Class Named StoreRequest
     *
     * Authorize by Policy if not have permission return HTTP 403 Forbidden.
     *
     * If have permission check this controller is defined var repository by isSetRepository()
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Using repository to create entity and return bool value to var isCreated
     *
     * Check if isCreated and redirect
     *
     * The redirect route name is get by getRouteName($name)
     * with param name equal with static::INDEX default value is 'index'
     * Set custom your route name by define const INDEX in this controller
     * If your route name is 'example.entity.custom-route define const INDEX by custom-route
     * Or you can remove $this->getRouteName(static::INDEX) by what ever route name you want.
     * -----------------------------------------------------------------------------------------
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ControllerException
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
     * Display the specified resource.
     * Default action method for route name show in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection ShowRequest to edit validate rules or something go to Class Named ShowRequest
     *
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Using repository to find model by findOneOrFail($id): return model entity or
     * return HTTP 404 NOT FOUND if missing in database
     *
     * Authorize by Policy if not have permission to show this model return HTTP 403 Forbidden.
     *
     * If have permission return view, view name get by getViewName($name)
     * with param name equal with static::SHOW default value is 'show'
     * Set custom your view name by define const SHOW in this controller
     * If your view name is 'example.entity.custom-show define const CREATE by custom-show
     * Or you can remove $this->getViewName(static::SHOW) by what ever view name you want
     * -----------------------------------------------------------------------------------------
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
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
     * Show the form for editing the specified resource.
     * Default action method for route name edit in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection EditRequest to edit validate rules or something go to Class Named EditRequest
     *
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Using repository to find model by findOneOrFail($id): return model entity or
     * return HTTP 404 NOT FOUND if missing in database
     *
     * Authorize by Policy if not have permission to show this model return HTTP 403 Forbidden.
     *
     * If have permission return view, view name get by getViewName($name)
     * with param name equal with static::EDIT default value is 'edit'
     * Set custom your view name by define const EDIT in this controller
     * If your view name is 'example.entity.custom-edit define const CREATE by custom-edit
     * Or you can remove $this->getViewName(static::EDIT) by what ever view name you want
     * -----------------------------------------------------------------------------------------
     * @param EditRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
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
     * Update the specified resource in storage.
     * Default action method for route name update in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection UpdateRequest to edit validate rules or something
     * go to Class Named UpdateRequest
     *
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Using repository to find model by findOneOrFail($id): return model entity or
     * return HTTP 404 NOT FOUND if missing in database
     *
     * Authorize by Policy if not have permission to update this model return HTTP 403 Forbidden.
     *
     * Using repository to update entity and return bool value to var isUpdated
     *
     * Check if isUpdated and redirect
     *
     * The redirect route name is get by getRouteName($name)
     * with param name equal with static::EDIT default value is 'edit'
     * Set custom your route name by define const EDIT in this controller
     * If your route name is 'example.entity.custom-route define const INDEX by custom-route
     * Or you can remove $this->getRouteName(static::EDIT) by what ever route name you want.
     * -----------------------------------------------------------------------------------------
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ControllerException
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
     * Remove the specified resource from storage.
     * Default action method for route name destroy in Route::resource
     * -----------------------------------------------------------------------------------------
     * Injection DeleteRequest to edit validate rules or something
     * go to Class Named DeleteRequest
     *
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Using repository to find model by findOneOrFail($id): return model entity or
     * return HTTP 404 NOT FOUND if missing in database
     *
     * Authorize by Policy if not have permission to delete this model return HTTP 403 Forbidden.
     *
     * Using repository to delete entity and return bool value to var isDeleted
     *
     * Check if isDeleted and redirect
     *
     * The redirect route name is get by getRouteName($name)
     * with param name equal with static::INDEX default value is 'index'
     * Set custom your route name by define const INDEX in this controller
     * If your route name is 'example.entity.custom-route define const INDEX by custom-route
     * Or you can remove $this->getRouteName(static::INDEX) by what ever route name you want.
     * -----------------------------------------------------------------------------------------
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
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
     * Do action on more model by one request
     * -----------------------------------------------------------------------------------------
     * Injection BulkRequest to edit validate rules or something
     * go to Class Named BulkRequest
     *
     * Authorize by Policy if not have permission to delete this model return HTTP 403 Forbidden.
     *
     * If is not set var repository throw Exception. All do by ifNotSetRepositoryThrowException()
     *
     * Get data from request
     *
     * In this controller define action 'delete'
     * Delete all models
     *
     * After all redirect or do some thing you want
     *
     * The redirect route name is get by getRouteName($name)
     * with param name equal with static::INDEX default value is 'index'
     * Set custom your route name by define const INDEX in this controller
     * If your route name is 'example.entity.custom-route define const INDEX by custom-route
     * Or you can remove $this->getRouteName(static::INDEX) by what ever route name you want.
     * -----------------------------------------------------------------------------------------
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
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
