<?php

namespace Protosofia\Rempathy\Contracts;

interface RepositoryInterface
{
    public function create($params);

    public function make($params);

    public function retrieve($params, $source);

    public function update($params, $data, $source);

    public function delete($params, $source);

    public function find($params, $source);
}
