<?php

namespace {namespace};

use Illuminate\Support\ServiceProvider;

class {entity}RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('{repositoryInterface}',
                              '{repository}');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['{repositoryInterface}'];
    }
}
