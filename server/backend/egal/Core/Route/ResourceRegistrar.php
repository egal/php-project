<?php

namespace Egal\Core\Route;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class ResourceRegistrar extends \Illuminate\Routing\ResourceRegistrar
{
    /**
     * @var ResourcesCacheStore
     */
    protected $resourcesCacheStore;

    public function __construct(Router $router, ResourcesCacheStore $resourcesCacheStore)
    {
        parent::__construct($router);

        $this->resourcesCacheStore = $resourcesCacheStore;
    }

    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['search', 'batchStore', 'batchUpdate', 'batchDestroy', 'batchRestore', 'index', 'store', 'show', 'update', 'destroy', 'restore'];

    /**
     * Add the search method for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceSearch(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/search';

        $action = $this->getResourceAction($name, $controller, 'search', $options);

        dump($options);
        return $this->router->post($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    /**
     * Add the restore method for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceRestore(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}/restore';

        $action = $this->getResourceAction($name, $controller, 'restore', $options);

        return $this->router->post($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    /**
     * Add the batch store method for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceBatchStore(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/batch';

        $action = $this->getResourceAction($name, $controller, 'batchStore', $options);

        return $this->router->post($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    /**
     * Add the batch update method for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceBatchUpdate(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/batch';

        $action = $this->getResourceAction($name, $controller, 'batchUpdate', $options);

        return $this->router->patch($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    /**
     * Add the batch destroy for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceBatchDestroy(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/batch';

        $action = $this->getResourceAction($name, $controller, 'batchDestroy', $options);

        return $this->router->delete($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    /**
     * Add the batch restore for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return Route
     */
    protected function addResourceBatchRestore(string $name, string $base, string $controller, array $options): Route
    {
        $uri = $this->getResourceUri($name).'/batch/restore';

        $action = $this->getResourceAction($name, $controller, 'batchRestore', $options);

        return $this->router->post($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceDestroy($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->delete($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceEdit($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.static::$verbs['edit'];

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->get($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceIndex($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->get($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceShow($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{id:'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->get($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceStore($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->post($uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    protected function addResourceUpdate($name, $base, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}';

        $action = $this->getResourceAction($name, $controller, 'main', $options);

        return $this->router->match(['PUT', 'PATCH'], $uri, $action)
            ->defaults('model_class', $options['model_class'])
            ->defaults('endpoints_class', $options['endpoints_class']);
    }

    public function register($name, $controller, array $options = [])
    {
        $this->resourcesCacheStore->addResource(
            new RegisteredResource(
                $controller,
                $this->getResourceMethods($this->resourceDefaults, $options)
            )
        );

        if (isset($options['parameters']) && ! isset($this->parameters)) {
            $this->parameters = $options['parameters'];
        }

        // If the resource name contains a slash, we will assume the developer wishes to
        // register these resource routes with a prefix so we will set that up out of
        // the box so they don't have to mess with it. Otherwise, we will continue.
        if (Str::contains($name, '/')) {
            $this->prefixedResource($name, $controller, $options);

            return;
        }

        // We need to extract the base resource from the resource name. Nested resources
        // are supported in the framework, but we need to know what name to use for a
        // place-holder on the route parameters, which should be the base resources.
        $base = $this->getResourceWildcard(last(explode('.', $name)));

        $defaults = $this->resourceDefaults;

        $collection = new RouteCollection;

        foreach ($this->getResourceMethods($defaults, $options) as $m) {
            $route = $this->{'addResource'.ucfirst($m)}(
                $name, $base, $controller, $options
            );

            if (isset($options['bindingFields'])) {
                $this->setResourceBindingFields($route, $options['bindingFields']);
            }

            $collection->add($route);
        }

        return $collection;
    }
}
