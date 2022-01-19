<?php

namespace App\Providers;

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
