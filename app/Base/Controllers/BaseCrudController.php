<?php


namespace App\Base\Controllers;

use App\Base\Controllers\Exceptions\ControllerException;
use App\Common\Users\Requests\StoreUserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

abstract class BaseCrudController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model;
    protected $entity;
    protected $repository;
    protected $policy;

    protected $request = Request::class;
    protected $request_for_action_index = Request::class;
    protected $request_for_action_create = Request::class;
    protected $request_for_action_store = Request::class;
    protected $request_for_action_show = Request::class;
    protected $request_for_action_edit = Request::class;
    protected $request_for_action_update = Request::class;
    protected $request_for_action_destroy = Request::class;
    protected $request_for_action_bulk = Request::class;

    const VIEW_ALIAS = '';
    const ROUTE_ALIAS = '';

    const INDEX = 'index';
    const CREATE = 'create';
    const STORE = 'store';
    const SHOW = 'show';
    const EDIT = 'edit';
    const UPDATE = 'update';
    const DESTROY = 'destroy';
    const BULK = 'bulk';

    /**
     * @param $case
     * @return string
     */
    protected function get_view_name($case)
    {
        return static::VIEW_ALIAS . '.' . $case;
    }

    /**
     * @param $case
     * @return string
     */
    static function get_route_name($case)
    {
        return static::ROUTE_ALIAS . '.' . $case;
    }

    /**
     * BaseCrudController constructor.
     * @throws ControllerException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $request_class_name
     * @return Request|mixed
     * @throws ControllerException
     */
    private function make_request_model(string $request_class_name)
    {
        $model = \App::make($request_class_name);

        if (!$model instanceof Request) {
            throw new ControllerException("Class {$request_class_name} must be an instance of Illuminate\\Http\\Request");
        }

        return $model;
    }

    /**
     * Display listing of resource
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $request = $this->make_request_model($this->request_for_action_index);

        if (!empty($this->policy) && !empty($this->entity)) {
            $this->authorize($this->policy::ABILITY_VIEW_ANY, $this->entity);
        }

        if (empty($this->repository)) {
            throw new ControllerException('$this->>repository must define');
        }

        $sort_field = $request->get('sort_field', 'id');
        $sort_by = $request->get('sort_order', 'desc');
        $per_page = $request->get('per_page', 10);
        $search_data = $request->get('search', []);

        $models = $this->repository
            ->orderBy($sort_field, $sort_by)
            ->search($search_data)
            ->paginate($per_page);

        $view_name = defined('static::VIEW_INDEX') ? static::VIEW_INDEX : $this->get_view_name(static::INDEX);

        return view($view_name, compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->make_request_model($this->request_for_action_create);

        if (!empty($this->policy) && !empty($this->entity)) {
            $this->authorize($this->policy::ABILITY_CREATE, $this->entity);
        }

        $view_name = defined('static::VIEW_CREATE') ? static::VIEW_CREATE : $this->get_view_name(static::CREATE);

        return view($view_name);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $request = $this->make_request_model($this->request_for_action_store);

        if (!empty($this->policy) && !empty($this->entity)) {
            $this->authorize($this->policy::ABILITY_CREATE, $this->entity);
        }

        if (empty($this->repository)) {
            throw new ControllerException('$this->repository must define');
        }

        $created = $this->repository->create($request->all());

        $redirect_route_name = defined('static::ROUTE_INDEX') ?
            static::ROUTE_INDEX : $this->get_route_name(static::INDEX);

        if (!$created) {
            return redirect(route($redirect_route_name))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirect_route_name))->with('success', __('Saved!'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id)
    {
        $this->make_request_model($this->request_for_action_show);

        if (empty($this->repository)) {
            throw new ControllerException('$this->repository must define');
        }

        $model = $this->repository->findOneOrFail($id);

        if (!empty($this->policy)) {
            $this->authorize($this->policy::ABILITY_VIEW, $model);
        }

        $view_name = defined('static::VIEW_SHOW') ? static::VIEW_SHOW : $this->get_view_name(static::SHOW);

        return view($view_name, compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $this->make_request_model($this->request_for_action_edit);

        if (empty($this->repository)) {
            throw new ControllerException('$this->repository must define');
        }

        $model = $this->repository->findOneOrFail($id);

        if (!empty($this->policy)) {
            $this->authorize($this->policy::ABILITY_UPDATE, $model);
        }

        $view_name = defined('static::VIEW_EDIT') ? static::VIEW_EDIT : $this->get_view_name(static::EDIT);

        return view($view_name, compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ControllerException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(int $id)
    {
        $request = $this->make_request_model($this->request_for_action_update);

        if (empty($this->repository)) {
            throw new ControllerException('$this->repository must define');
        }

        $model = $this->repository->findOneOrFail($id);

        if (!empty('$this->policy')) {
            $this->authorize($this->policy::ABILITY_UPDATE, $model);
        }

        $updated = $this->repository->update($model, $request->all());

        $redirect_route_name = defined('static::ROUTE_EDIT') ?
            static::ROUTE_EDIT : $this->get_route_name(static::EDIT);

        if (!$updated) {
            return redirect(route($redirect_route_name, $id))->with('error', __('Not Saved!'));
        }

        return redirect(route($redirect_route_name, $id))->with('success', __('Saved!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $this->make_request_model($this->request_for_action_destroy);

        if (empty($this->repository)) {
            throw new ControllerException('$this->repository must define');
        }

        $model = $this->repository->findOneOrFail($id);

        if (!empty($this->policy)) {
            $this->authorize($this->policy::ABILITY_DELETE, $model);
        }

        $deleted = $this->repository->deleteById($id);

        $redirect_route_name = defined('static::ROUTE_INDEX') ?
            static::ROUTE_INDEX : $this->get_route_name(static::INDEX);

        if (!$deleted) {
            return redirect(route($redirect_route_name))->with('error', __('Not Deleted!'));
        }

        return redirect()->back()->with('success', __('Deleted!'));
    }

    /**
     * Do action on more model by one request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function bulk()
    {
        $request = $this->make_request_model($this->request_for_action_bulk);

        if (!empty($this->policy) && !empty($this->entity)) {
            $this->authorize($this->policy::ABILITY_BULK, $this->entity);
        }

        $action = $request->post('action');
        $ids = $request->post('ids');
        $message = '';

        switch ($action) {
            case 'delete':
                $this->repository->destroy($ids);
                $message = __('Deleted!');
                break;
        }

        $redirect_route_name = defined('static::ROUTE_INDEX') ?
            static::ROUTE_INDEX : $this->get_route_name(static::INDEX);

        return redirect(route($redirect_route_name))->with('success', $message);
    }
}
