<?php

namespace Egal\Core;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;

class Application extends LaravelApplication
{

    /**
     * Indicates if the class aliases have been registered.
     *
     * @var bool
     */
    protected static $aliasesRegistered = false;

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
     * Register the facades for the application.
     *
     * @param  bool  $aliases
     * @param  array  $userAliases
     * @return void
     */
    public function withFacades($aliases = true, $userAliases = [])
    {
        Facade::setFacadeApplication($this);

        if ($aliases) {
            $this->withAliases($userAliases);
        }
    }

    /**
     * Register the aliases for the application.
     *
     * @param  array  $userAliases
     * @return void
     */
    public function withAliases($userAliases = [])
    {
        $defaults = [
            \Illuminate\Support\Facades\Auth::class => 'Auth',
            \Illuminate\Support\Facades\Cache::class => 'Cache',
            \Illuminate\Support\Facades\DB::class => 'DB',
            \Illuminate\Support\Facades\Event::class => 'Event',
            \Illuminate\Support\Facades\Gate::class => 'Gate',
            \Illuminate\Support\Facades\Log::class => 'Log',
            \Illuminate\Support\Facades\Queue::class => 'Queue',
            \Illuminate\Support\Facades\Route::class => 'Route',
            \Illuminate\Support\Facades\Schema::class => 'Schema',
            \Illuminate\Support\Facades\Storage::class => 'Storage',
            \Illuminate\Support\Facades\URL::class => 'URL',
            \Illuminate\Support\Facades\Validator::class => 'Validator',
        ];

        if (! static::$aliasesRegistered) {
            static::$aliasesRegistered = true;

            $merged = array_merge($defaults, $userAliases);

            foreach ($merged as $original => $alias) {
                class_alias($original, $alias);
            }
        }
    }

    /**
     * Bootstrap the router instance.
     *
     * @return void
     */
    public function bootstrapRouter()
    {
        $this->router = new Router($this['events'], $this);
    }

    /**
     * Register container bindings for the application.
     *
     * @return void
     */
    protected function registerRouterBindings()
    {
        $this->singleton('router', function () {
            return $this->router;
        });
    }

    public function flush()
    {
        parent::flush();
        $this->router = null;
    }

}
