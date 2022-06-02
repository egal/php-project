<?php

namespace Egal\Core\Rest;

use Egal\Core\Auth\Ability;
use Egal\Core\Database\Model;
use Egal\Core\Exceptions\ObjectNotFoundException;
use Egal\Core\Facades\Auth;
use Egal\Core\Facades\Gate;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Illuminate\Support\Facades\Validator;

class Controller
{

    /**
     * TODO: Selecting (with relation loading), filtering, sorting, scoping.
     */
    public function index(string $modelClass, FilterQuery $filter): \Illuminate\Http\JsonResponse
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $collection = $model::filter($filter)
//            ->select()
            ->get();

        foreach ($collection as $object) {
            Gate::allowed(Auth::user(), Ability::Show, $object);
        }

        return  \response()->json([
            'message' => null,
            'data' => $collection->toArray(),
            'meta' => '',
        ]);
    }

    public function show(string $modelClass, $key): \Illuminate\Http\JsonResponse
    {
        Gate::allowed(Auth::user(), Ability::ShowAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Show, $object);

        return  \response()->json([
            'message' => null,
            'data' => $object->toArray(),
            'meta' => '',
        ]);
    }

    public function create(string $modelClass, array $attributes = []): \Illuminate\Http\JsonResponse
    {
        Gate::allowed(Auth::user(), Ability::CreateAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $metadata = $model->getMetadata();

        # TODO: Add messages.
        # TODO: What is $customAttributes param in Validator::make.
        Validator::make($attributes, $metadata->getValidationRules())->validate();

        $object = $model->fill($attributes);

        Gate::allowed(Auth::user(), Ability::Create, $object);

        return  \response()->json([
            'message' => 'Created successfully',
            'data' => [ "id" => $object->id ],  //TODO primaryKey instead id
            'meta' => '',
        ]);
    }

    public function update(string $modelClass, $key, array $attributes = []): \Illuminate\Http\JsonResponse
    {
        Gate::allowed(Auth::user(), Ability::UpdateAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Update, $object);

        $metadata = $model->getMetadata();
        Validator::make($attributes, $metadata->getValidationRules())->validate();

        $object->update($attributes);

        return  \response()->json([
            'message' => 'Updated successfully',
            'data' => [ "id" => $object->id ],  //TODO primaryKey instead id
            'meta' => '',
        ]);
    }

    public function delete(string $modelClass, $key): \Illuminate\Http\JsonResponse
    {
        Gate::allowed(Auth::user(), Ability::DeleteAny, $modelClass);

        $model = $this->newModelInstance($modelClass);
        $object = $this->getModelObjectById($model, $key);

        Gate::allowed(Auth::user(), Ability::Delete, $object);

        $object->delete();

        return  \response()->json([
            'message' => 'Deleted successfully',
            'data' => null,  //TODO primaryKey instead id
            'meta' => '',
        ]);
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
