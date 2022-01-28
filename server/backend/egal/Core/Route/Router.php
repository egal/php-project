<?php

namespace Egal\Core\Route;

use Egal\Core\Controllers\APIController;
use Egal\Core\Support\ClassFinder;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;
use Illuminate\Routing\PendingResourceRegistration as LaravelPendingResourceRegistration;

class Router extends \Illuminate\Routing\Router
{

    public function __construct(Dispatcher $events)
    {
        parent::__construct($events);
    }

    /**
     * @throws Exception
     */
    public function parse(string $namespaceModels, string $namespaceEndpoints): void
    {
        $models = ClassFinder::getClasses($namespaceModels, 'Egal\Core\Model\Model');
        $endpoints = ClassFinder::getClasses($namespaceEndpoints, 'Egal\Core\Model\Endpoints');

        $this->parseModelRoutes($this->getModelEndpoints($models, $endpoints), $namespaceEndpoints);
    }

    /**
     * Route a resource to a controller.
     *
     * @param string $name
     * @param string $controller
     * @param array $options
     *
     * @return LaravelPendingResourceRegistration
     *
     * @throws BindingResolutionException
     */
    public function resource($name, $controller, array $options = []): LaravelPendingResourceRegistration
    {
        if ($this->container && $this->container->bound(ResourceRegistrar::class)) {
            $registrar = $this->container->make(ResourceRegistrar::class);
        } else {
            $registrar = new ResourceRegistrar($this, app()->make(ResourcesCacheStore::class));
        }

        return new PendingResourceRegistration(
            $registrar, $name, $controller, $options
        );
    }

    private function getModelEndpoints(array $models, array $endpoints): array
    {
        $modelEndpoints = [];
        foreach ($endpoints as $endpoint) {
            $modelName = str_replace('Endpoints', '', $endpoint);
            if (in_array($modelName, $models)) {
                $modelEndpoints[$modelName] = $endpoint;
            }
        }

        foreach (array_diff($models, array_keys($modelEndpoints)) as $modelName) {
            $modelEndpoints[$modelName] = 'Endpoints';
        }

        return $modelEndpoints;
    }

    /**
     * @throws Exception
     */
    private function parseModelRoutes($modelEndpoints, string $namespaceEndpoints): void
    {
        foreach ($modelEndpoints as $model => $endpoint) {
            $model = strtolower($model);
            app('router')->resource('/' . Str::plural($model), APIController::class, ['as' => 'api']);

            if ($endpoint !== 'Endpoints') {
                $customEndpoints = get_class_methods($namespaceEndpoints . '\\' . $endpoint);
                foreach ($customEndpoints as $customEndpoint) {
                    $this->generateCustomRoute($customEndpoint, $model);
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    private function generateCustomRoute(string $endpoint, $model): void
    {
        $endpointParts = [];
        $defaultEndpoints = implode('|', EndpointMethod::getAllEndpointMethods());
        $endpointPattern = '/(endpoint)(' . $defaultEndpoints . ')([a-zA-Z]+)/i';
        if (preg_match($endpointPattern, $endpoint, $endpointParts)) {
            $endpointMethod = $endpointParts[2];
            $httpMethod = EndpointMethod::getHttpMethod($endpointMethod);

            $paramUrl = EndpointMethod::isWithId($endpointMethod) ? '/{id}' : '';
            $uri = '/' . Str::plural($model) . '/' . strtolower($endpointParts[3]) . $paramUrl;

            app('router')
                ->$httpMethod($uri, ['as' => 'api', 'uses' => 'Egal\Core\Controllers\APIController@main' . $endpoint]);
        }
    }

}
