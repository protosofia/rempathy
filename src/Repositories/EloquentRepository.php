<?php

namespace Protosofia\Rempathy\Repositories;

use Illuminate\Database\Eloquent\Model;
use Protosofia\Rempathy\Contracts\RepositoryInterface;

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
     * Retrieve records
     *
     * @param array $params Record data for filter purposes
     *
     * @return Collection | boolean Record collection or false
     */
    public function retrieve($params = [])
    {
        $query = $this->parseParams($params);

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

        $query = $this->parseParams($params);

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
        $query = $this->parseParams($params);

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
        $query = $this->parseParams($params);

        return $query->first();
    }

    /**
     * Build a query based on params
     *
     * @param array $params Conditions of the query
     *
     * @return Model
     */
    protected function parseParams(array $params)
    {
        $query = $this->model;

        if (empty($params)) return $query;

        if (!is_array(reset($params))) $params = [$params];

        $clauses = [
            'where' => 'where',
            'or' => 'orWhere',
            'between' => 'whereBetween',
            'not between' => 'whereNotBetween',
            'in' => 'whereIn',
            'not in' => 'whereNotIn',
            'null' => 'whereNull',
            'not null' => 'whereNotNull',
            'collumn' => 'whereColumn'
        ];

        foreach ($params as $param) {
            if (empty($param)) continue;

            try {
                $clause = $clauses[$param[0]];
                $args = array_slice($param, 1);
            } catch (\Exception $e) {
                continue;
            }

            $func = array($query, $clause);

            $query = call_user_func_array($func, $args);
        }

        return $query;
    }
}
