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

    const EGAL_CORE_MODEL_ENDPOINTS = 'Egal\Core\Model\Endpoints';

    public function __construct(Dispatcher $events)
    {
        parent::__construct($events);
    }

    /**
     * @throws Exception
     */
    public function parse(string $namespaceModels, string $namespaceEndpoints): void
    {
        $models = ClassFinder::getClasses(app_path('/Models'), $namespaceModels, 'Egal\Core\Model\Model');
        $endpoints = ClassFinder::getClasses(app_path('/Endpoints'), $namespaceEndpoints, self::EGAL_CORE_MODEL_ENDPOINTS);

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
        foreach ($endpoints as $endpointName => $endpointClass) {
            $modelName = str_replace('Endpoints', '', $endpointName);
            if (array_key_exists($modelName, $models)) {
                $modelEndpoints[$models[$modelName]] = $endpointClass;
            }
        }

        foreach (array_diff($models, array_keys($modelEndpoints)) as $modelClass) {
            $modelEndpoints[$modelClass] = self::EGAL_CORE_MODEL_ENDPOINTS;
        }

        return $modelEndpoints;
    }

    /**
     * @throws Exception
     */
    private function parseModelRoutes($modelEndpoints, string $namespaceEndpoints): void
    {
        foreach ($modelEndpoints as $model => $endpoint) {
            $modelReflectionClass = new \ReflectionClass($model);
            app('router')
                ->resource(
                    '/' . Str::plural(strtolower($modelReflectionClass->getShortName())),
                    APIController::class,
                    [
                        'as' => 'api',
                        'model_class' => $model,
                        'endpoints_class' => $endpoint
                    ]
                );

            if ($endpoint !== self::EGAL_CORE_MODEL_ENDPOINTS) {
                $customEndpointsMethods = get_class_methods($endpoint);
                foreach ($customEndpointsMethods as $customEndpointsMethod) {
                    $this->generateCustomRoute($customEndpointsMethod, $model, $endpoint);
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    private function generateCustomRoute(string $endpointMethod, string $model, string $endpoint): void
    {
        $endpointsMethodParts = [];
        $defaultEndpoints = implode('|', EndpointMethod::getAllEndpointMethods());
        $endpointsMethodPattern = '/(endpoint)(' . $defaultEndpoints . ')([a-zA-Z]+)/i';
        $modelReflectionClass = new \ReflectionClass($model);
        if (preg_match($endpointsMethodPattern, $endpointMethod, $endpointsMethodParts)) {
            $endpointMethod = $endpointsMethodParts[2];
            $httpMethod = EndpointMethod::getHttpMethod($endpointMethod);

            $paramUrl = EndpointMethod::isWithId($endpointMethod) ? '/{id}' : '';
            $uri = '/' . Str::plural(strtolower($modelReflectionClass->getShortName())) . '/'
                . strtolower($endpointsMethodParts[3]) . $paramUrl;

            app('router')
                ->$httpMethod($uri, ['as' => 'api', 'uses' => 'Egal\Core\Controllers\APIController@main' . $endpointMethod])
                ->defaults('model_class', $model)
                ->defaults('endpoints_class', $endpoint);
        }
    }

}
