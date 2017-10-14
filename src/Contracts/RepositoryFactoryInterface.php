<?php

namespace Protosofia\Rempathy\Contracts;

use Protosofia\Rempathy\Contracts\RepositoryInterface;

interface RepositoryFactoryInterface
{
    /**
     * Build a new repository instance
     * @param   string  $name  Model name
     * @return  object
     */
    public static function build(string $name) : RepositoryInterface;
}
