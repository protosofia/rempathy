<?php

namespace Protosofia\Rempathy\Services;

use Protosofia\Rempathy\Contracts\RepositoryQueryResolverInterface;

class EloquentRespositoryQueryResolver implements RepositoryQueryResolverInterface
{
    /**
     * Build a query based on params
     *
     * @param array $params Conditions of the query
     *
     * @return Model
     */
    public function parseParams($query, array $params)
    {
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