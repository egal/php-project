<?php

namespace Egal\Core;

use Egal\Auth\Session;
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
            if (class_exists('Egal\Core\RouteServiceProvider')) {
                $this->app->register('Egal\Core\RouteServiceProvider');
            }
        }
    }

}