<?php


namespace App\Common\Users\Entities;

use App\Base\Entities\BaseEntity;

/**
 * App\Common\Users\Entities\RoleEntity
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Common\Users\Entities\UserEntity[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Common\Users\Entities\RoleEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Common\Users\Entities\RoleEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Common\Users\Entities\RoleEntity query()
 * @mixin \Eloquent
 */
class RoleEntity extends BaseEntity
{
    protected $fillable = [
        'name', 'slug', 'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UserEntity::class, 'role_users');
    }
}
