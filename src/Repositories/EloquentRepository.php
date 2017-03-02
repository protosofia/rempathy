<?php

namespace Protosofia\Rempathy\Repositories;

use Protosofia\Rempathy\Contracts\ModelInterface;
use Protosofia\Rempathy\Contracts\RepositoryInterface;

class EloquentRepository implements RepositoryInterface
{
    /**
     * @var ModelInterface $model Model instance
     */
    protected $model;

    /**
     * Create a new instance of NetworkCrudService
     *
     * @param ModelInterface $model Model instance
     *
     * @return void
     */
    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new record
     *
     * @param array $params Record data
     *
     * @return ModelInterface | boolean Stored record or false
     */
    public function create($params)
    {
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
