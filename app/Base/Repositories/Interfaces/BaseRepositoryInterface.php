<?php


namespace App\Base\Repositories\Interfaces;


use App\Base\Repositories\BaseRepository;
use App\Base\Repositories\Exceptions\UpdateModelInvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data) : bool;

    /**
     * @param string $orderBy
     * @param string $sortBy
     * @return $this
     */
    public function orderBy(string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete() : bool;

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteById($id): bool;

    /**
     * @param array $ids
     * @return int
     */
    public function destroy(array $ids): int;

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, array $columns = ['*']);

    /**
     * @param $id
     * @return mixed
     */
    public function findOneOrFail($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 15, $columns = ['*']);

    /**
     * @param $data = ['column' => 'value', 'column 2' => 'value 2']
     * @return mixed
     */
    public function search($data);

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations);

    /**
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields);

    /**
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields);

    /**
     * @return mixed
     */
    public function first();

    /**
     * @param string $column
     * @param string $condition
     * @param $value
     * @return $this|BaseRepositoryInterface
     */
    public function where(string $column, string $condition, $value);

    /**
     * @param array $columns
     * @return mixed
     */
    public function get($columns = ['*']);
}
