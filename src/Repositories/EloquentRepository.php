<?php

namespace Protosofia\Rempathy\Repositories;

use Illuminate\Database\Eloquent\Model;
use Protosofia\Rempathy\Contracts\RepositoryInterface;
use Protosofia\Rempathy\Services\EloquentRepositoryQueryResolver;

class EloquentRepository implements RepositoryInterface
{
    /**
     * @var Model $model Model instance
     */
    protected $model;

    /**
     * @var array $createFields Fillable fields on create
     */
    protected $createFields;

    /**
     * @var array $updateFields Fillable fields on update
     */
    protected $updateFields;

    /**
     * @var EloquentRepositoryQueryResolver $queryResolver EloquentRepositoryQueryResolver instance
     */
    protected $queryResolver;

    /**
     * Create a new instance of NetworkCrudService
     *
     * @param Model $model Model instance
     *
     * @return void
     */
    public function __construct(
        Model $model,
        $createFields = false,
        $updateFields = false
    ) {
        $this->model = $model;
        $this->createFields = $createFields;
        $this->updateFields = $updateFields;
    }

    /**
     * Set fillable fields on create
     *
     * @param array $fields Fillable fields on create
     *
     * @return void
     */
    public function setCreateFields(array $fields)
    {
        $this->createFields = $fields;
    }

    /**
     * Set fillable fields on update
     *
     * @param array $fields Fillable fields on update
     *
     * @return void
     */
    public function setUpdateFields(array $fields)
    {
        $this->updateFields = $fields;
    }

    /**
     * Get valid fields array
     *
     * @param array $params Record data
     *
     * @return array Valid params array
     */
    public function getValidParams($params, $fieldsList = false)
    {
        $fields = (!$fieldsList) ? $this->model->getFillable() : $fieldsList;

        $callback = function ($key) use ($fields) {
            return (array_search($key, $fields) !== false);
        };

        return array_filter($params, $callback, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Create a new record
     *
     * @param array $params Record data
     *
     * @return Model | boolean Stored record or false
     */
    public function create($params)
    {
        $params = $this->getValidParams($params, $this->createFields);

        return $this->model->create($params);
    }

    /**
     * Make a new record
     *
     * @param array $params Record data
     *
     * @return Model
     */
    public function make($params)
    {
        $params = $this->getValidParams($params, $this->createFields);

        return $this->model->make($params);
    }

    /**
     * Retrieve records
     *
     * @param array $params Record data for filter purposes
     *
     * @return Collection | boolean Record collection or false
     */
    public function retrieve($params = [])
    {
        $queryResolver = new EloquentRepositoryQueryResolver();

        $query = $queryResolver->parseParams($this->model, $params);

        return $query->get();
    }

    /**
     * Update records
     *
     * @param array $params Network records update data
     *
     * @return integer How many records was updated
     */
    public function update($params, $data)
    {
        $data = $this->getValidParams($data, $this->updateFields);

        $queryResolver = new EloquentRepositoryQueryResolver();

        $query = $queryResolver->parseParams($this->model, $params);

        return $query->update($data);
    }

    /**
     * Delete records
     *
     * @param array $params Records ids
     *
     * @return integer How many records was deleted
     */
    public function delete($params)
    {
        $queryResolver = new EloquentRepositoryQueryResolver();

        $query = $queryResolver->parseParams($this->model, $params);

        return $query->delete();
    }

    /**
     * Retrieve a single record
     *
     * @param array $params Record data for filter purposes
     *
     * @return Model | boolean Record or false
     */
    public function find($params = [])
    {
        $queryResolver = new EloquentRepositoryQueryResolver();

        $query = $queryResolver->parseParams($this->model, $params);

        return $query->first();
    }
}
