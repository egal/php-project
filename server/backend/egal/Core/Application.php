<?php

namespace Egal\Core;

use Egal\Core\Route\Router;
use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    protected string $modelNamespace;
    protected string $endpointsNamespace;

    protected string $modelPath;
    protected string $endpointsPath;


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

    public function getModelNamespace(): string
    {
        return $this->modelNamespace;
    }

    public function getEndpointsNamespace(): string
    {
        return $this->endpointsNamespace;
    }

    public function getModelPath(): string
    {
        return $this->modelPath;
    }

    public function getEndpointsPath(): string
    {
        return $this->endpointsPath;
    }

    public function setModelNamespace(string $modelNamespace)
    {
        $this->modelNamespace = $modelNamespace;
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
        // TODO почистить роут, а не роут назначать null
        $this->router = null;
    }

    public function setEndpointsNamespace(string $endpointsNamespace)
    {
        $this->endpointsNamespace = $endpointsNamespace;
    }

    public function setModelPath(string $modelPath)
    {
        $this->modelPath = $modelPath;
    }

    public function setEndpointsPath(string $endpointsPath)
    {
        $this->endpointsPath = $endpointsPath;
    }

}
