<?php

namespace Egal\Core;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{

    /**
     * The Router instance.
     *
     * @var Router
     */
    public $router;

    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
        $this->bootstrapRouter();
    }

    /**
     * Bootstrap the router instance.
     *
     * @return void
     */
    public function bootstrapRouter()
    {
        $this->router = new Router($this['events']);
    }

    public function flush()
    {
        parent::flush();
        $this->router = null;
    }

}
