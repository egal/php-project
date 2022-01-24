<?php

namespace Egal\Core;

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

    public static function parse(): void
    {
        $models = self::getModels();
        $endpoints = self::getModelEndpoints($models);
        $routes = self::parseModelRoutes($endpoints);
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
        $resourceRoutePattern = "\Egal\Core\Facades\Route::resource('/resourceName');";

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

            in_array($httpEndpoint, ['Show', 'Update', 'Delete'])
                ? app('router')->$httpMethod('/' . Str::plural($model) . '/{id}', ['as' => 'api', 'uses' => 'Egal\Core\APIController@' . $endpoint])
                : app('router')->$httpMethod('/' . Str::plural($model), ['as' => 'api', 'uses' => 'Egal\Core\APIController@' . $endpoint]);

        }

    }
}