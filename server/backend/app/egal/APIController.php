<?php

namespace App\egal;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class APIController
{
    public function index(Request $request)
    {
        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->index($request);
    }

    public function show($id, Request $request)
    {
        $model = $request->getModelInstanse();

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->show($id, $request);
    }

    public function create(Request $request)
    {
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();

        $request->validate($validationRules);

        /** @var EgalEndpoints $endpoints */
        $endpoints =  "App\\Endpoints\\" . $model->getName() . "Endpoints";

        return $endpoints->create($request->only('attributes'), $request);
    }

    public function update($id, Request $request)
    {
        $model = $request->getModelInstanse();
        $validationRules = $model->getModelMetadata()->getValidationRules();

        $request->validate($validationRules); //проверять все, кроме required

        /** @var EgalEndpoints $endpoints */
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
