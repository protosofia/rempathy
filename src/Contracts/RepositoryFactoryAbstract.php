<?php

namespace Protosofia\Rempathy\Contracts;

use App;
use Protosofia\Rempathy\Contracts\RepositoryInterface;
use Protosofia\Rempathy\Contracts\RepositoryFactoryInterface;

abstract RepositoryFactoryAbstract implements RepositoryFactoryInterface
{
    /**
     * @var  array  $repositories  Repositories namespace
     */
    protected $repositories;

    /**
     * Build a new repository instance
     * @param   string  $name  Model name
     * @return  object
     */
    public static function build(string $name) : RepositoryInterface
    {
        return App::make($this->getRepositoryNamespace($name));
    }

    /**
     * Return the repository namespace
     * @param   string  $name  Model name
     * @return  string  Repository namespace
     */
    protected function getRepositoryNamespace(string $name) : string
    {
        return  (isset($this->repositories[$name])) 
                ? $this->repositories[$name]
                : throw new \Exception('No repository defined for this model name.');
    }
}
