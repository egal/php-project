<?php

namespace Egal\Core;

use Carbon\Laravel\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class RouteGeneratorServiceProvider extends LaravelServiceProvider
{
    protected const ENDPOINT_METHOD = [
        'Index' => 'get',
        'Show' => 'get',
        'Create' => 'post',
        'Update' => 'put',
        'Delete' => 'delete'
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->generateRoutes();
    }

    private function generateRoutes()
    {
        $models = $this->getModels();
        $endpoints = $this->getModelEndpoints($models);
        $routes = $this->getModelRoutes($endpoints);
        // сделать очистку роутов
        file_put_contents(base_path('routes/api.php'), $routes, FILE_APPEND );
    }

    public function getModels(): array
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

    private function getModelEndpoints(array $models)
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

    public function getModelRoutes($endpoints): array
    {
        $routes = [];
        $resourceRoutePattern = "\Egal\Core\Facades\Route::resource('/resourceName');";

        foreach ($endpoints as $model => $endpoint) {
            $model = strtolower($model);
            $routes[] = str_replace('resourceName', $model, $resourceRoutePattern) . PHP_EOL;

            if ($endpoint !== 'Endpoints') {
                $customEndpoints = get_class_methods('App\Endpoints' . '\\' . $endpoint);
                foreach ($customEndpoints as $customEndpoint) {
                    $endpointParts = [];
                    $defaultEndpoints = 'Index|Show|Update|Create|Delete';
                    $endpointPattern = '/(endpoint)(' . $defaultEndpoints . ')([a-zA-Z]+)/i';
                    if (preg_match($endpointPattern, $customEndpoint, $endpointParts)) {
                        $routes[] = $this->generateCustomRoute($endpointParts, $model) . PHP_EOL;
                    }
                }
            }
        }
        return $routes;
    }

    private function generateCustomRoute(array $endpointParts, $model)
    {
        $endpoint = $endpointParts[2];

        $endpointPattern = in_array($endpoint, ['Show', 'Update', 'Delete'])
            ? "\Illuminate\Support\Facades\Route::method('/model/{id}');"
            : "\Illuminate\Support\Facades\Route::method('/model');";

        return str_replace(
            ["method", "model"],
            [self::ENDPOINT_METHOD[$endpoint], $model],
            $endpointPattern
        );
    }
}