<?php

namespace App\egal;

use App\egal\auth\Session;

class EgalEndpoints
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return '';
    }

    public function index()
    {
        if (Session::user()->cannot(__METHOD__)) {
            throw new NoAccessException();
        }
        return $this->model->newQuery()->get();
    }

    public function show($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function create($attributes)
    {
        // посмотреть на реализацию Sanctum
        if (Session::user()->cannot(__METHOD__)) {
            throw new NoAccessException();
        }
        return $this->model->newQuery()->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

    public function relationIndex()
    {
        return $this->model->newQuery()->get();
    }

    public function relationShow($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function relationCreate($attributes)
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function relationUpdate($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function relationDelete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

}
