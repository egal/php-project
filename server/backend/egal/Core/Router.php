<?php

namespace Egal\Core;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Router extends \Illuminate\Routing\Router
{
    protected const ENDPOINT_METHOD = [
        'Index' => 'get',
        'Show' => 'get',
        'Create' => 'post',
        'Update' => 'put',
        'Delete' => 'delete'
    ];

    public function __construct(Dispatcher $events)
    {
        parent::__construct($events);
    }

    public static function parse(): void
    {
        $models = self::getModels();
        $endpoints = self::getModelEndpoints($models);
        self::parseModelRoutes($endpoints);
    }

    public static function getModels(): array
    {
        // нужно вынести в класс хелпер
        $models = [];

        foreach (scandir(base_path('app/Models')) as $model) {
            $model = str_replace('.php', '', $model);
            if (is_dir($model)) {
                continue;
            } else {
                if (get_parent_class('App\Models' . '\\' . $model) === 'Egal\Core\Model') {
                    $models[] = $model;
                }
            }
        }
        return $models;
    }

    private static function getModelEndpoints(array $models)
    {
        $modelEndpoints = [];
        foreach (scandir(base_path('app/Endpoints')) as $endpoint) {
            $endpoint = str_replace('.php', '', $endpoint);
            if (is_dir($endpoint)) {
                continue;
            } else {
                if (get_parent_class('App\Endpoints' . '\\' . $endpoint) === 'Egal\Core\Endpoints') {
                    $modelName = str_replace('Endpoints', '', $endpoint);
                    if (in_array($modelName, $models)) {
                        $modelEndpoints[$modelName] = $endpoint;
                    }
                }
            }
        }
        foreach (array_diff($models, array_keys($modelEndpoints)) as $modelName) {
            $modelEndpoints[$modelName] = 'Endpoints';
        }
        return $modelEndpoints;
    }

    public static function parseModelRoutes($endpoints): array
    {
        $routes = [];

        foreach ($endpoints as $model => $endpoint) {
            $model = strtolower($model);
            app('router')->resource('/' . Str::plural($model), APIController::class, ['as' => 'api']);

            if ($endpoint !== 'Endpoints') {
                $customEndpoints = get_class_methods('App\Endpoints' . '\\' . $endpoint);
                foreach ($customEndpoints as $customEndpoint) {
                    self::generateCustomRoute($customEndpoint, $model) . PHP_EOL;
                }
            }
        }
        return $routes;
    }

    private static function generateCustomRoute(string $endpoint, $model)
    {
        $endpointParts = [];
        $defaultEndpoints = 'Index|Show|Update|Create|Delete';
        $endpointPattern = '/(endpoint)(' . $defaultEndpoints . ')([a-zA-Z]+)/i';
        if (preg_match($endpointPattern, $endpoint, $endpointParts)) {
            $httpEndpoint = $endpointParts[2];
            $httpMethod = self::ENDPOINT_METHOD[$httpEndpoint];

            $endpointName = $endpointParts[3];
            in_array($httpEndpoint, ['Show', 'Update', 'Delete'])
                ? app('router')->$httpMethod('/' . Str::plural($model) . '/' . strtolower($endpointName) . '/{id}', ['as' => 'api', 'uses' => 'Egal\Core\APIController@main' . $endpoint])
                : app('router')->$httpMethod('/' . Str::plural($model) . '/' . strtolower($endpointName), ['as' => 'api', 'uses' => 'Egal\Core\APIController@' . $endpoint]);

        }

    }

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\PendingResourceRegistration
     */
    public function resource($name, $controller, array $options = [])
    {
        if ($this->container && $this->container->bound(\Egal\Core\ResourceRegistrar::class)) {
            $registrar = $this->container->make(ResourceRegistrar::class);
        } else {
//            if (app()->bound(ResourcesCacheStore::class)) {
//                return app()->make(ResourcesCacheStore::class);
//            }
            $registrar = new ResourceRegistrar($this, app()->make(ResourcesCacheStore::class));
        }

        return new \Egal\Core\PendingResourceRegistration(
            $registrar, $name, $controller, $options
        );
    }


}