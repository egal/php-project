<?php

namespace Egal\Core;

use Egal\Auth\Session;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class APIController
{
    public function index(Request $request)
    {
        Session::user();
        $model = $request->getModelInstanse();

        /** @var Endpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->index();
    }

    public function show($id, Request $request)
    {
        if (($request->hasHeader('Authorization'))) {
            Session::setToken($request->header('Authorization'));
        }

        $model = $request->getModelInstanse();

        if (Session::user()->cannot('endpointShow', $model)) {
            abort(403);
        }

        /** @var Endpoints $endpoints */
        $endpointsClass =  "App\\Endpoints\\" . $model->getName() . "Endpoints";
        if (!class_exists($endpointsClass)) {
            $endpointsClass = Endpoints::class;
        }
        $endpoint = new $endpointsClass($model);

        return $endpoint->show($id);
    }

    public function store(Request $request, Post $model)
    {
       \session()->put('UST', $request->header('authorization'));
       $request->user();
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();
        $request->validate($validationRules);

        /** @var Endpoints $endpointsClass */
        $endpointsClass =  "App\\Endpoints\\" . $model->getName() . "Endpoints";
        $endpoint = new $endpointsClass();

        return $endpoint->create($request->only('attributes'));
    }

    public function update($id, Request $request, Post $model)
    {
        Log::debug($model->toArray());
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();

        $inputAttributes = $request->request;
        $oldAttributes = $model->newQuery()->find($id)->first;
        $missingAttributes = array_diff_key($oldAttributes, (array)$inputAttributes);
        $inputAttributes->add($missingAttributes);

        $request->validate($validationRules);

        /** @var Endpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->update($id, $request->only('attributes'));
    }

    public function delete($id, Request $request)
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

    public function relationCreate(Request $request)
    {
        return $this->service->create($request->only('attributes'));
    }

    public function relationUpdate($id, Request $request)
    {
        return $this->service->update($id, $request->only('attributes'));
    }

    public function relationDelete($id, Request $request)
    {
        return $this->service->delete($id);
    }


}
