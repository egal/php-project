<?php

namespace Egal\Core;

use Egal\Auth\Session;
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
            throw new EgalCoreInitializationException(
                'Application needs instants of ' . Application::class . ' detected ' . get_class($this->app) . '!'
            );
        }

        $this->app->singleton(ResourcesCacheStore::class);
        $this->app->alias('request', EgalRequest::class);
        $this->app->singleton(Session::class, static fn () => new Session());

        $this->app->bind('EgalRoute', EgalRoute::class);


        if ($this->app->runningInConsole()) {
            if (class_exists('Egal\Core\RouteGeneratorServiceProvider')) {
                $this->app->register('Egal\Core\RouteGeneratorServiceProvider');
            }
        }

        $this->commands([
            GenerateModelCommand::class,
            GenerateCustomEndpointCommand::class,
            GenerateInterfaceMetadataCommand::class,
            GeneratePolicyCommand::class,
            GenerateMigrationCommand::class,
        ]);
    }

}