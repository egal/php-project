<?php

namespace Egal\Core;

use Egal\Core\Auth\Session;
use Egal\Core\Commands\GenerateCustomEndpointCommand;
use Egal\Core\Commands\GenerateInterfaceMetadataCommand;
use Egal\Core\Commands\GenerateMigrationCommand;
use Egal\Core\Commands\GenerateModelCommand;
use Egal\Core\Commands\GeneratePolicyCommand;
use \Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        if (!($this->app instanceof Application)) {
            throw new CoreInitializationException(
                'Application needs instants of ' . Application::class . ' detected ' . get_class($this->app) . '!'
            );
        }

        $this->app->singleton(ResourcesCacheStore::class);
        $this->app->alias('request', Request::class);
        $this->app->singleton(Session::class, static fn () => new Session());

        $this->app->bind('EgalRoute', Route::class);
        $this->app->singleton('router', Router::class);

        $this->commands([
            GenerateModelCommand::class,
            GenerateCustomEndpointCommand::class,
            GenerateInterfaceMetadataCommand::class,
            GeneratePolicyCommand::class,
            GenerateMigrationCommand::class,
        ]);
    }

}