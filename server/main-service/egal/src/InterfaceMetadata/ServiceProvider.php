<?php

namespace Egal\InterfaceMetadata;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton('egal.interface.metadata.manager', fn($app) => new Manager());
    }
}
