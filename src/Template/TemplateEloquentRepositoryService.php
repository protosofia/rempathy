<?php

namespace {namespace};

use {entity};
use Protosofia\Rempathy\Repositories\EloquentRepository;

class {entityName}EloquentRepository extends EloquentRepository
{
    /**
     * Create a new instance of TemplateEloquentRepository
     *
     * @param Template $model Template model instance
     *
     * @return void
     */
    public function __construct({entityName} $model)
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
        return parent::create($params);
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
        return parent::retrieve($params);
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
        return parent::update($params);
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
        return parent::delete($params);
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
        return parent::find($params);
    }
}
