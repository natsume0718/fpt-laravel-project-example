<?php

namespace App\Policies\Admin\Users;

use App\Base\Policies\BasePolicy;
use App\Common\Users\Entities\UserEntity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    const PERMISSION_ALIAS = 'user';

    const PERMISSION_VIEW_ANY = self::PERMISSION_ALIAS . '.viewAny';
    const PERMISSION_VIEW = self::PERMISSION_ALIAS . '.view';
    const PERMISSION_CREATE = self::PERMISSION_ALIAS . '.create';
    const PERMISSION_UPDATE = self::PERMISSION_ALIAS . '.update';
    const PERMISSION_DELETE = self::PERMISSION_ALIAS . '.delete';
    const PERMISSION_BULK = self::PERMISSION_ALIAS . '.bulk';

    /**
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->inRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasAccess([self::PERMISSION_VIEW_ANY]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param UserEntity $model
     * @return mixed
     */
    public function view(User $user, UserEntity $model)
    {
        return $user->hasAccess([self::PERMISSION_VIEW]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess([self::PERMISSION_CREATE]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UserEntity $model
     * @return mixed
     */
    public function update(User $user, UserEntity $model)
    {
        return $user->hasAccess([self::PERMISSION_UPDATE]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, UserEntity $model)
    {
        return $user->hasAccess([self::PERMISSION_DELETE]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param UserEntity $model
     * @return mixed
     */
    public function bulk(User $user)
    {
        return $user->hasAccess([self::PERMISSION_BULK]);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param UserEntity $model
     * @return mixed
     */
    public function restore(User $user, UserEntity $model)
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param UserEntity $model
     */
    public function forceDelete(User $user, UserEntity $model)
    {
        //
    }
}
