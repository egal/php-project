<?php

namespace Egal\Core;

use Egal\Core\Auth\Session;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class APIController
{
    public function main(\Illuminate\Http\Request $request, ...$params)
    {
        // поиск соответствующей регулярки для запроса
        //
        // нужен класс хелпер для установки верных namespace, если внутри все по папкам, например
        $request = self::createEndpointRequest($request);
        return $request->call();
    }

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

    /**
     * @param Request $request
     * @return void
     */
    private static function createEndpointRequest(\Illuminate\Http\Request $request): Request
    {
        $endpointRequest = new Request();

        if (($request->hasHeader('Authorization'))) {
            Session::setToken($request->header('Authorization'));
        }
        $endpointRequest->setHttpMethod($request->getMethod());

        foreach ($request->segments() as $key => $segment) {
            switch ($key) {
                case 0:
                    $modelName = 'App\Models\\' . ucwords(Str::singular($request->segments()[0]));
                    $model = new $modelName();
                    $endpointRequest->setModel($model);
                    break;
                case 1:
                    $model = $endpointRequest->getModel();
                    // нужен класс хелпер для установки верных namespace, если внутри все по папкам, например
                    $endpointsClass = 'App\Endpoints\\' . ucwords(Str::singular($endpointRequest->getModel())) . 'Endpoints';
                    if (!class_exists($endpointsClass) || !method_exists($endpointsClass, $segment)) {
                        $endpointsClass = Endpoints::class;
                        $endpointRequest->setId($segment);
                    } else {
                        $endpointRequest->setEndpointMethod($segment);
                    }
                    $endpointRequest->setEndpoint(new $endpointsClass($model));
                    break;
                case 2:
                    $model = $endpointRequest->getModel();
                    if (!in_array($segment, $model::getModelMetadata()->getRelationNames())) {
                        $endpointRequest->setId($segment);
                    } else {
                        $modelMetadata = $model::getModelMetadata();
                        $relationClass = $modelMetadata->getRelationsData()[$segment];
                        $endpointRequest->setRelation($relationClass);
                    }
                    break;
                case 3:
                    $endpointsClass = 'App\Endpoints\\' . ucwords(Str::singular($endpointRequest->getRelation())) . 'Endpoints';
                    if (!class_exists($endpointsClass) || !method_exists($endpointsClass, $segment)) {
                        $endpointsClass = Endpoints::class;
                        $endpointRequest->setId($segment);
                    } else {
                        $endpointRequest->setEndpointMethod($segment);
                    }
                    $endpointRequest->setEndpoint(new $endpointsClass());
                    break;
                case 4:
                    $endpointRequest->setId($segment);
                    break;
            }
        }
        return $endpointRequest;
    }

}
