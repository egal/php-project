<?php

namespace Egal\Core;

use Illuminate\Support\ServiceProvider;

class EgalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('EgalRoute', EgalRoute::class);
    }
}
