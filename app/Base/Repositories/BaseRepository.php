<?php


namespace App\Base\Repositories;

use App\Base\Repositories\Exceptions\CreateModelInvalidArgumentException;
use App\Base\Repositories\Exceptions\RepositoryException;
use App\Base\Repositories\Exceptions\UpdateModelInvalidArgumentException;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use App\Base\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @throws RepositoryException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model|mixed
     * @throws RepositoryException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeModel()
    {
        $model = \App::make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws CreateModelInvalidArgumentException
     */
    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateModelInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     * @throws RepositoryException
     * @throws UpdateModelInvalidArgumentException
     */
    public function update(Model $model, array $data): bool
    {
        if (is_a($model, $this->model())) {
            try {
                return $model->update($data);
            } catch (QueryException $e) {
                throw new UpdateModelInvalidArgumentException($e);
            }
        } else {
            throw new RepositoryException("Class {\$model} must be same with " . $this->model());
        }
    }

    /**
     * @param string $orderBy
     * @param string $sortBy
     * @return $this
     */
    public function orderBy(string $orderBy = 'id', string $sortBy = 'asc')
    {
        $this->model = $this->model->orderBy($orderBy, $sortBy);
        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function deleteById($id): bool
    {
        $this->model = $this->findOneOrFail($id);

        return $this->model->delete();
    }

    /**
     * @param array $ids
     * @return int
     */
    public function destroy(array $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, array $columns = ['*'])
    {
        try {
            return $this->model->find($id, $columns);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOneOrFail($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        $this->model = $this->model->where($data);
        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data)
    {
        try {
            return $this->model->where($data)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

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

    /**
     * @param string $column
     * @param string $condition
     * @param $value
     * @return $this|BaseRepositoryInterface
     */
    public function where(string $column, string $condition, $value)
    {
        $this->model = $this->model->where($column, $condition, $value);

        return $this;
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->model->setVisible($fields);

        return $this;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function get($columns = ['*'])
    {
        return $this->model->get($columns);
    }
}
