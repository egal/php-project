<?php

namespace Egal\Core\Rest;

use Egal\Core\Auth\Ability;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\ObjectNotFoundException;
use Egal\Core\Exceptions\ValidateException;
use Egal\Core\Facades\Auth;
use Egal\Core\Facades\Gate;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Egal\Core\Rest\Pagination\PaginationParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class Controller
{

    public function index(string $modelClass, PaginationParams $pagination, array $scope = [], FilterQuery $filter = null, array $select = [], array $order = []): array
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $paginator = $model::restScope($scope)
            ->restFilter($filter)
            ->restSelect($select)
            ->restOrder($order)
            ->paginate($pagination->getPerPage(), ['*'], 'page', $pagination->getPage());

        $collection = $paginator->items();

        foreach ($collection as $object) {
            Gate::allowed(Auth::user(), Ability::Show, $object);
        }

        return  [
            'items' => $collection,
            'current_page' => $paginator->currentPage(),
            'total_count' => $paginator->total(),
            'per_page' => $paginator->perPage(),
        ];
    }

    public function show(string $modelClass, $key, array $select = []): array
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $model::restSelect($select)
            ->find($key);

        if (!$object) {
            throw new ObjectNotFoundException();
        }

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

        $keyName = $model->getKeyName();
        return  [$keyName => $object->$keyName];
    }

    public function update(string $modelClass, $key, array $attributes = []): array
    {
        Gate::allowed(Auth::user(), Ability::UpdateAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $model->newQuery()->find($key);

        if (!$object) {
            throw new ObjectNotFoundException();
        }

        Gate::allowed(Auth::user(), Ability::Update, $object);

        $metadata = $model->getMetadata();
        $validator = Validator::make($attributes, $metadata->getValidationRules());

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }

        $object->update($attributes);

        $keyName = $model->getKeyName();
        return  [$keyName => $object->$keyName];
    }

    public function delete(string $modelClass, $key): void
    {
        Gate::allowed(Auth::user(), Ability::DeleteAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $model->newQuery()->find($key);

        if (!$object) {
            throw new ObjectNotFoundException();
        }

        Gate::allowed(Auth::user(), Ability::Delete, $object);

        $object->delete();
    }

    public function metadata(string $modelClass): array
    {
        return $this->newModelInstance($modelClass)->getMetadata()->toArray();
    }

    protected function newModelInstance(string $modelClass): Model
    {
        return new $modelClass();
    }

}
