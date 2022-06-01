<?php

namespace Egal\Core;

use Egal\Core\Auth\Gate;
use Egal\Core\Auth\Manager;
use Egal\Core\Http\Route;
use Egal\Core\Rest\Controller;
use Egal\Core\Rest\Filter\Parser as FilterParser;
use Egal\Core\Rest\Select\Parser as SelectParser;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('egal.gate', fn($app) => new Gate());
        $this->app->singleton('egal.rest', fn($app) => new Controller());
        $this->app->singleton('egal.auth', fn($app) => new Manager());
        $this->app->singleton('egal.route', fn($app) => new Route());
        $this->app->singleton('egal.filter.parser', fn($app) => new FilterParser());
        $this->app->singleton('egal.select.parser', fn($app) => new SelectParser());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

}
