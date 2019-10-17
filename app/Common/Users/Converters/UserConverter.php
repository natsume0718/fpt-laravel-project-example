<?php


namespace App\Common\Users\Converters;


use App\Base\Converters\BaseConverter;
use App\Common\Users\Entities\UserEntity as Entity;
use App\Common\Users\Models\User as Model;

class UserConverter extends BaseConverter
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
            ->setEmail($entity->email)
            ->setPassword($entity->password)
            ->setEmailVerifiedAt($entity->email_verified_at)
            ->setRememberToken($entity->remember_token);

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
            'email' => $model->getEmail(),
            'password' => $model->getPassword(),
            'email_verified_at' => $model->getEmailVerifiedAt(),
            'remember_token' => $model->getRememberToken(),
        ]);
    }
}
