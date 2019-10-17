<?php


namespace App\Base\Policies;


abstract class BasePolicy
{
    const ABILITY_CREATE = 'create';
    const ABILITY_VIEW = 'view';
    const ABILITY_VIEW_ANY = 'viewAny';
    const ABILITY_UPDATE = 'update';
    const ABILITY_DELETE = 'delete';
    const ABILITY_BULK = 'bulk';
}
