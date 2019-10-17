<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    /**
     * @param $data = ['column' => 'value', 'column 2' => 'value 2']
     * @return mixed
     */
    public function search($data)
    {
        foreach ($data as $column => $value) {
            $this->where($column, 'like', '%' . $value . '%');
        }

        return $this;
    }
}
