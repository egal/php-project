<?php

namespace Egal\Core\Rest;

use Egal\Core\Auth\Ability;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\ObjectNotFoundException;
use Egal\Core\Exceptions\ValidateException;
use Egal\Core\Facades\Auth;
use Egal\Core\Facades\Gate;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function response;

class Controller
{

    /**
     * TODO: Selecting (with relation loading), filtering, sorting, scoping.
     */
    public function index(string $modelClass, FilterQuery $filter): array
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $collection = $model::filter($filter)
//            ->select()
//            ->order()
//            ->paginate()
            ->get();

        foreach ($collection as $object) {
            Gate::allowed(Auth::user(), Ability::Show, $object);
        }

        return  $collection->toArray();
    }

    public function show(string $modelClass, $key): array
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Show, $object);

        return  $object->toArray();
    }

    public function create(string $modelClass, array $attributes = []): array
    {
        Gate::allowed(Auth::user(), Ability::CreateAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $metadata = $model->getMetadata();

        # TODO: Add messages.
        # TODO: What is $customAttributes param in Validator::make.
        $validator = Validator::make($attributes, $metadata->getValidationRules());

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }

        $object = $model->fill($attributes);
        $object->save();

        Gate::allowed(Auth::user(), Ability::Create, $object);

        return  ["id" => $object->id];
    }

    public function update(string $modelClass, $key, array $attributes = []): array
    {
        Gate::allowed(Auth::user(), Ability::UpdateAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Update, $object);

        $metadata = $model->getMetadata();
        $validator = Validator::make($attributes, $metadata->getValidationRules());

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }

        $object->update($attributes);

        return  [ "id" => $object->id ];
    }

    public function delete(string $modelClass, $key): void
    {
        Gate::allowed(Auth::user(), Ability::DeleteAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Delete, $object);

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
