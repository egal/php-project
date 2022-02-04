<?php

namespace Egal\Core\Model;

use Egal\Core\Auth\Session;
use App\Models\Post;
use Egal\Core\Model\Exceptions\NoAccessException;
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
    }

    public function endpointIndex()
    {
        return $this->model->newQuery()->get()->toArray();
    }

    public function endpointShow($attributes)
    {
        $entity = $this->model->newQuery()->find($attributes['id']);
        return $entity->toArray();
    }

    public function endpointCreate($attributes)
    {
        // посмотреть на реализацию Sanctum
//        if (Session::user()->cannot(__METHOD__)) {
//            throw new NoAccessException();
//        }
        return $this->model->newQuery()->create($attributes)->toArray();
    }

    public function endpointUpdate($id, $attributes)
    {
        $entity = $this->model->newQuery()->find($id);
        $entity->update($attributes);
        return $entity->toArray();
    }

    public function endpointDelete($id)
    {
        $entity = $this->model->newQuery()->find($id);
        $entity->delete();
        return $entity->toArray();
    }
}
