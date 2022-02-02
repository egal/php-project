<?php

namespace Egal\Core\Controllers;

use Egal\Core\Auth\Session;
use Egal\Core\Model\Endpoints;
use Egal\Core\Model\Model;
use Egal\Core\Route\Request;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request as LaravelRequest;

class APIController
{

    /**
     * @throws Exception
     */
    public function main(LaravelRequest $request): array
    {

        if (($request->hasHeader('Authorization'))) {
            Session::setToken($request->header('Authorization'));
        }

        $request = $this->createEndpointRequest($request);
        $request->setAttributes($request->toArray());

        return $request->call();
    }

    /**
     * @param LaravelRequest $request
     *
     * @return Request
     *
     */
    private function createEndpointRequest(LaravelRequest $request): Request
    {
        $endpointRequest = new Request();

        $endpointRequest->setHttpMethod($request->getMethod());

        $this->setRequestParams($request, $endpointRequest);

        return $endpointRequest;
    }

    private function setRequestParams(LaravelRequest $request, Request $endpointRequest): void
    {

        $model = new ($request->route()->parameter('model_class'));
        $endpointsClass = $request->route()->parameter('endpoints_class');
        $endpointRequest->setModel($model);

        foreach ($request->segments() as $key => $segment) {
            switch ($key) {
                case 1:
                    $this->setMethod($endpointRequest, $segment, $model, $endpointsClass);
                    break;
                case 2:
                    $this->setRelationModel($endpointRequest, $segment, $model);
                    break;
                case 3:
                    $model = $endpointRequest->getRelation();
                    $this->setMethod($endpointRequest, $segment, $model, $endpointsClass);
                    break;
                case 4:
                    $endpointRequest->setId($segment);
//   TODO             default
            }
        }
    }

    private function setMethod(Request $endpointRequest, ?string $segment, Model $model, string $endpointsClass): void
    {
        if (!class_exists($endpointsClass) || !method_exists($endpointsClass, $segment)) {
            $endpointsClass = Endpoints::class;
            $endpointRequest->setId($segment);
        } else {
            $endpointRequest->setCustomMethod($segment);
        }

        $endpointRequest->setEndpoint(new $endpointsClass($model));
    }

    private function setRelationModel(Request $endpointRequest, ?string $segment, Model $model): void
    {
        if (!in_array($segment, $model::getModelMetadata()->getRelationNames())) {
            $endpointRequest->setId($segment);
        } else {
            $modelMetadata = $model::getModelMetadata();
            $relationClass = $modelMetadata->getRelationsData()[$segment];
            $endpointRequest->setRelation($relationClass);
        }
    }

}
