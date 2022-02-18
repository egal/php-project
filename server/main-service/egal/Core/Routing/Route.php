<?php

namespace Egal\Core\Routing;

use Egal\Core\Database\Model;
use Egal\Core\Http\Controller;
use Illuminate\Support\Facades\Route as IlluminateRoute;

class Route
{

    public static function rest(string $modelClass): void
    {
        /** @var Model $model */
        $model = new $modelClass();
        $metadata = $model->initializeMetadata();

        IlluminateRoute::get("/{$metadata->getPluralName()}", [Controller::class, 'index'])
            ->defaults('model_class', $metadata->getClass());

        IlluminateRoute::get("/{$metadata->getPluralName()}/{key}", [Controller::class, 'show'])
            ->defaults('model_class', $metadata->getClass());

        IlluminateRoute::post("/{$metadata->getPluralName()}", [Controller::class, 'create'])
            ->defaults('model_class', $metadata->getClass());

        IlluminateRoute::delete("/{$metadata->getPluralName()}/{key}", [Controller::class, 'delete'])
            ->defaults('model_class', $metadata->getClass());

        IlluminateRoute::patch("/{$metadata->getPluralName()}/{key}", [Controller::class, 'update'])
            ->defaults('model_class', $metadata->getClass());
    }

}
