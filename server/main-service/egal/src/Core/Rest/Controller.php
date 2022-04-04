<?php

namespace Egal\Core\Rest;

use Egal\Core\Auth\Ability;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\NoAccessException;
use Egal\Core\Facades\Auth;
use Egal\Core\Facades\Gate;
use Exception;
use Illuminate\Support\Facades\Validator;

class Controller
{

    public function index(string $modelClass, array $filter = []): array
    {
        $model = $this->newModelInstance($modelClass);
        $collection = $model->newQuery()->get();

        Gate::allowed(Auth::user(), Ability::showAny, $modelClass);

        foreach ($collection as $entity) {
            Gate::allowed(Auth::user(), Ability::show, $entity);
        }

        return $collection->toArray();
    }

    public function create(string $modelClass, array $attributes = []): void
    {
        $model = $this->newModelInstance($modelClass);
        $metadata = $model->getMetadata();

        # TODO: Add messages.
        # TODO: What is $customAttributes param in Validator::make.
        Validator::make($attributes, $metadata->getValidationRules())->validate();

        $model->fill($attributes)->save();
    }

    protected function newModelInstance(string $modelClass): Model
    {
        return new $modelClass();
    }

}
