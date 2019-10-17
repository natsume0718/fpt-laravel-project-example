<?php


namespace App\Common\Users\Converters;


use App\Base\Converters\BaseConverter;
use App\Common\Users\Entities\RoleEntity as Entity;
use App\Common\Users\Models\Role as Model;

class RoleConverter extends BaseConverter
{
    /**
     *
     * @param Entity $entity
     * @return Model
     */
    public static function convertEntityToModel($entity)
    {
        $model = new Model();
        $model->setName($entity->name)
            ->setSlug($entity->slug)
            ->setPermissions($entity->permissions);

        return $model;
    }

    /**
     * @param Model $model
     * @return Entity
     */
    public static function convertModelToEntity($model)
    {
        return new Entity([
            'name' => $model->getName(),
            'slug' => $model->getSlug(),
            'permissions' => $model->getPermissions(),
        ]);
    }
}
