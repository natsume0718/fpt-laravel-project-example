<?php


namespace App\Common\Users\Models;

use App\Base\Models\BaseModel;

/**
 * Class User
 * @package App\Common\Users\Models
 */
class Role extends BaseModel
{
    private $name;
    private $slug;
    private $permissions;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return Role
     */
    public function setSlug(string $slug): Role
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param $permissions
     * @return Role
     */
    public function setPermissions(array $permissions): Role
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $permission
     * @return bool
     */
    private function hasPermission(string $permission): bool
    {
        return $this->permissions[$permission] ?? false;
    }
}
