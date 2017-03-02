<?php

namespace Protosofia\Rempathy\Contracts;

interface RepositoryInterface
{
    public function create($params);

    public function retrieve($params);

    public function update($params, $data);

    public function delete($params);

    public function find($params);
}
