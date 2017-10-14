<?php

namespace Protosofia\Rempathy\Repositories;

use App;
use Protosofia\Rempathy\Contracts\RepositoryInterface;
use Protosofia\Rempathy\Contracts\RepositoryFactoryInterface;

class EloquentRepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * @var  array  $repositories  Repositories namespace
     */
    protected static $repositories = [
        // 'Model' => 'Eloquent\Model\Namespace',
    ];

    /**
     * Build a new repository instance
     * @param   string  $name  Model name
     * @return  object
     */
    public static function build(string $name) : RepositoryInterface
    {
        $namespace = (isset(self::$repositories[$name])) 
                     ? self::$repositories[$name]
                     : false;

        if (!$namespace) {
            throw new \Exception('Repository not defined.');
        }

        return App::make($namespace);
    }
}