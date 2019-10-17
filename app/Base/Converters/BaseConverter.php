<?php


namespace App\Base\Converters;

use Illuminate\Database\Eloquent\Model as Entity;
use App\Base\Models\BaseModel as Model;

abstract class BaseConverter
{
    abstract static function convertEntityToModel($entity);

    abstract static function convertModelToEntity($model);

    /**
     * @param $entities
     * @return \Illuminate\Support\Collection
     */
    public static function convertEntitiesToModels($entities)
    {
        return collect($entities)->map(function ($entity) {
            return self::convertEntityToModel($entity);
        });
    }

    /**
     * @param $models
     * @return \Illuminate\Support\Collection
     */
    public static function convertModelsToEntities($models)
    {
        return collect($models)->map(function ($model) {
            return self::convertModelToEntity($model);
        });
    }
}
