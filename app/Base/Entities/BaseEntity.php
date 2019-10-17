<?php


namespace App\Base\Entities;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Base\Entities\BaseEntity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Base\Entities\BaseEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Base\Entities\BaseEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Base\Entities\BaseEntity query()
 * @mixin \Eloquent
 */
abstract class BaseEntity extends Model
{

}
