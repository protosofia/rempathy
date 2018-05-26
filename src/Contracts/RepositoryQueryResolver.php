<?php

namespace Protosofia\Rempathy\Contracts;

interface RepositoryQueryResolver
{
    /**
     * Build a query based on params
     *
     * @param array $params Conditions of the query
     *
     * @return Model
     */
    public function parseParams($query, array $params);
}
