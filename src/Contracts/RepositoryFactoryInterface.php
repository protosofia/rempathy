<?php

namespace Protosofia\Rempathy\Contracts;

interface RepositoryFactoryInterface
{
    /**
     * Build a new repository instance
     * @param   string  $name  Model name
     * @return  object
     */
    public static function build(string $name) : object;
}
