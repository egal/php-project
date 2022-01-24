<?php

namespace Egal\Core;

use Egal\Core\Auth\Session;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class Endpoints
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected string $modelClass;

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->modelClass = get_class($model);
        // по названию парсинг класса, либо getModelClass
    }

    public function endpointIndex()
    {
        return $this->model->newQuery()->get();
    }

    public function endpointShow($id)
    {
        $entity = $this->model->newQuery()->find($id);
        return $entity->toArray();
    }

    public function endpointCreate($attributes)
    {
        // посмотреть на реализацию Sanctum
        if (Session::user()->cannot(__METHOD__)) {
            throw new NoAccessException();
        }
        return $this->model->newQuery()->create($attributes);
    }

    public function endpointUpdate($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function endpointDelete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

    public function endpointRelationIndex()
    {
        return $this->model->newQuery()->get();
    }

    public function endpointRelationShow($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function endpointRelationCreate($attributes)
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function endpointRelationUpdate($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function endpointRelationDelete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

}
