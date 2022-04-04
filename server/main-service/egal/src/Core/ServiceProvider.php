<?php

namespace Egal\Core;

use Egal\Core\Auth\Gate;
use Egal\Core\Interfaces\Gate as GateInterface;
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
        $this->app->singleton(GateInterface::class, fn() => new Gate());
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
