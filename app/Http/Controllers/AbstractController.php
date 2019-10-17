<?php

namespace App\Http\Controllers;

use App\Base\Controllers\Exceptions\ControllerException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public const VIEW_ALIAS = null;
    public const ROUTE_ALIAS = null;

    const INDEX = 'index';
    const CREATE = 'create';
    const STORE = 'store';
    const SHOW = 'show';
    const EDIT = 'edit';
    const UPDATE = 'update';
    const DESTROY = 'destroy';
    const BULK = 'bulk';

    /**
     * Return view name string by add VIEW_ALIAS to first
     *
     * @param string $name
     * @return string
     */
    public static function getViewName(string $name): string
    {
        return static::VIEW_ALIAS . '.' . $name;
    }

    /**
     * Return route name string by add ROUTE_ALIAS to first
     *
     * @param string $name
     * @return string
     */
    public static function getRouteName(string $name): string
    {
        return static::ROUTE_ALIAS . '.' . $name;
    }
}
