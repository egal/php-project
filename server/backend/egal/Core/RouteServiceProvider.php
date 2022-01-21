<?php

namespace Egal\Core;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';
    protected const ENDPOINT_METHOD = [
      'Index' => 'get',
      'Show' => 'get',
      'Create' => 'post',
      'Update' => 'put',
      'Delete' => 'delete'
    ];

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->generateRoutes();

        $this->routes(function () {
            Route::middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    private function generateRoutes()
    {
        $models = $this->getModels();
        $endpoints = $this->getModelEndpoints($models);
        $routes = $this->getModelRoutes($endpoints);
        // сделать очистку роутов
        file_put_contents('routes/api.php', $routes, FILE_APPEND );
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
                if (get_parent_class('App\Models' . '\\' . $model) === 'Egal\Core\EgalModel') {
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
                if (get_parent_class('App\Endpoints' . '\\' . $endpoint) === 'Egal\Core\EgalEndpoints') {
                    $modelName = str_replace('Endpoints', '', $endpoint);
                    if (in_array($modelName, $models)) {
                        $modelEndpoints[$modelName] = $endpoint;
                    }
                }
            }
        }
        foreach (array_diff($models, array_keys($modelEndpoints)) as $modelName) {
            $modelEndpoints[$modelName] = 'EgalEndpoints';
        }
        return $modelEndpoints;
    }

    public function getModelRoutes($endpoints): array
    {
        $routes = [];
        $resourceRoutePattern = "\Egal\Core\Facades\EgalRoute::resource('/resourceName');";

        foreach ($endpoints as $model => $endpoint) {
            $model = strtolower($model);
            $routes[] = str_replace('resourceName', $model, $resourceRoutePattern) . PHP_EOL;

            if ($endpoint !== 'EgalEndpoints') {
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
