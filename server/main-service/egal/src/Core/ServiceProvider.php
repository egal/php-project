<?php

namespace Egal\Core;

use Egal\Core\Auth\Gate;
use Egal\Core\Auth\Manager;
use Egal\Core\Http\Route;
use Egal\Core\Rest\Controller;
use Egal\Core\Rest\Filter\Parser as FilterParser;
use Egal\Core\Rest\Select\Parser as SelectParser;
use Egal\Core\Rest\Scope\Parser as ScopeParser;
use Egal\Core\Rest\Order\Parser as OrderParser;
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
        $this->app->singleton('egal.scope.parser', fn($app) => new ScopeParser());
        $this->app->singleton('egal.order.parser', fn($app) => new OrderParser());
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
