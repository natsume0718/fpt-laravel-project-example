<?php

namespace App\Common\Users\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Common\Users\Entities\UserEntity;
use App\Common\Users\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return UserEntity::class;
    }
}
