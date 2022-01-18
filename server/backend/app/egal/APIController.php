<?php

namespace App\egal;

use App\egal\auth\Session;
use Illuminate\Support\Facades\Log;

class APIController
{
    public function index(EgalRequest $request)
    {
        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->index($request);
    }

    public function show($id, EgalRequest $request)
    {
        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->show($id, $request);
    }

    public function create(EgalRequest $request)
    {
       \session()->put('UST', $request->header('authorization'));
       $request->user();
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();
        $request->validate($validationRules);

        /** @var EgalEndpoints $endpointsClass */
        $endpointsClass =  "App\\Endpoints\\" . $model->getName() . "Endpoints";
        $endpoint = new $endpointsClass();

        return $endpoint->create($request->only('attributes'), $request);
    }

    public function update($id, EgalRequest $request)
    {
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();

        $inputAttributes = $request->request;
        $oldAttributes = $model->newQuery()->find($inputAttributes['id'])->first;
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
