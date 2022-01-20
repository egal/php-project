<?php

namespace App\Providers;

use App\egal\auth\Session;
use App\egal\EgalRequest;
use App\egal\EgalRoute;
use App\egal\ResourcesCacheStore;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResourcesCacheStore::class);
        $this->app->alias('request', EgalRequest::class);
        $this->app->singleton(Session::class, static fn () => new Session());


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('EgalRoute', EgalRoute::class);

    }
}
