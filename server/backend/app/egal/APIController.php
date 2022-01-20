<?php

namespace App\egal;

use App\egal\auth\Session;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class APIController
{
    public function index(EgalRequest $request)
    {
        Session::user();
        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->index();
    }

    public function show($id, EgalRequest $request)
    {
        if (($request->hasHeader('Authorization'))) {
            Session::setToken($request->header('Authorization'));
        }
        if (Session::user()->cannot(__METHOD__)) {
            throw new NoAccessException();
        }

        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpointsClass =  "App\\Endpoints\\" . $model->getName() . "Endpoints";
        $endpoint = new $endpointsClass();

        return $endpoint->show($id);
    }

    public function store(EgalRequest $request, Post $model)
    {
       \session()->put('UST', $request->header('authorization'));
       $request->user();
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();
        $request->validate($validationRules);

        /** @var EgalEndpoints $endpointsClass */
        $endpointsClass =  "App\\Endpoints\\" . $model->getName() . "Endpoints";
        $endpoint = new $endpointsClass();

        return $endpoint->create($request->only('attributes'));
    }

    public function update($id, EgalRequest $request, Post $model)
    {
        Log::debug($model->toArray());
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();

        $inputAttributes = $request->request;
        $oldAttributes = $model->newQuery()->find($id)->first;
        $missingAttributes = array_diff_key($oldAttributes, (array)$inputAttributes);
        $inputAttributes->add($missingAttributes);

        $request->validate($validationRules);

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->update($id, $request->only('attributes'));
    }

    public function delete($id, EgalRequest $request)
    {
        return $this->service->delete($id);
    }

    public function relationIndex()
    {
        //validation
        return $this->service->index();
    }

    public function relationShow($id)
    {
        return $this->service->show($id);
    }

    public function relationCreate(EgalRequest $request)
    {
        return $this->service->create($request->only('attributes'));
    }

    public function relationUpdate($id, EgalRequest $request)
    {
        return $this->service->update($id, $request->only('attributes'));
    }

    public function relationDelete($id, EgalRequest $request)
    {
        return $this->service->delete($id);
    }


}
