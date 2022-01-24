<?php

namespace Egal\Core;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Route
{
    /**
     * @param ResourceRegistrar $registrar
     * @param string $name
     * @param string $controller
     * @param array $options
     * @return PendingResourceRegistration
     */
    protected function makePendingResourceRegistration(ResourceRegistrar $registrar, string $name, string $controller, array $options): PendingResourceRegistration
    {
        return new PendingResourceRegistration(
            $registrar, $name, $controller, $options
        );
    }

    public function resource(string $resource, array $options = []): PendingResourceRegistration
    {
        $controller = Session::isStarted() ? RPCController::class : APIController::class;
        $registrar = $this->resolveRegistrar(ResourceRegistrar::class);

        return $this->makePendingResourceRegistration($registrar, $resource, $controller, $options);
        // работает с index, create, show ....
    }

    public function morphToManyResource(string $resource, string $relation, array $access, array $options = []): PendingResourceRegistration
    {
        // работает с relationIndex, relationCreate, relationShow ....
    }

    protected function resolveRegistrar(string $registrarClass): ResourceRegistrar
    {
        if (app()->bound($registrarClass)) {
            return app()->make($registrarClass);
        }

        return new $registrarClass(app('router'), $this->resolveResourcesCacheStore());
    }

    protected function resolveResourcesCacheStore(): ResourcesCacheStore
    {
        if (app()->bound(ResourcesCacheStore::class)) {
            return app()->make(ResourcesCacheStore::class);
        }

        throw new BindingResolutionException('ResourcesCacheStore is not bound to the container');
    }

    public function parse($modelsFolderPath, $modelsFolderNamespace): void
    {
//        foreach () {
//            \Illuminate\Support\Facades\Route::index('/entity')
//                ->defaults('model', \App\Models\Entity::class)
//                ->defaults('endpoints', \Egal\Core\Endpoints::class)
//                ->defaults('polisy', \Egal\Core\HttpPolicy::class);
//        }
    }

}
