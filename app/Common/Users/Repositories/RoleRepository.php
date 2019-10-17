<?php

namespace App\Common\Users\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Common\Users\Entities\RoleEntity;
use App\Common\Users\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return RoleEntity::class;
    }
}
