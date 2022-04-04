<?php

namespace Egal\Core\Rest;

use Egal\Core\Auth\Ability;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\ObjectNotFoundException;
use Egal\Core\Facades\Auth;
use Egal\Core\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class Controller
{

    /**
     * TODO: Selecting (with relation loading), filtering, sorting, scoping.
     */
    public function index(string $modelClass): array
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

    public function show(string $modelClass, $key): array
    {
        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        return $object->toArray();
    }

    public function update(string $modelClass, $key, array $attributes = []): void
    {
        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        $metadata = $model->getMetadata();
        Validator::make($attributes, $metadata->getValidationRules())->validate();

        $object->update($attributes);
    }

    public function delete(string $modelClass, $key): void
    {
        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        $object->delete();
    }

    protected function newModelInstance(string $modelClass): Model
    {
        return new $modelClass();
    }

    protected function getModelObjectById(Model $model, $key): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array
    {
        $object = $model->newQuery()->find($key);

        if (!$object) {
            throw new ObjectNotFoundException();
        }
        return $object;
    }

}
