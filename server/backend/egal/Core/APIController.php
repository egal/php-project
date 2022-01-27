<?php

namespace Egal\Core;

use Egal\Core\Auth\Session;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request as LaravelRequest;

class APIController
{

    public $endpointsNamespace;
    public $model;

    /**
     * @throws Exception
     */
    public function main(LaravelRequest $request): array
    {
        if (($request->hasHeader('Authorization'))) {
            Session::setToken($request->header('Authorization'));
        }

        $request = $this->createEndpointRequest($request);

        return $request->call();
    }

    /**
     * @param LaravelRequest $request
     *
     * @return Request
     *
     * @throws Auth\UnableDecodeTokenException
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
        $this->endpointsNamespace = config('namespaces.endpoints');
        foreach ($request->segments() as $key => $segment) {
            switch ($key) {
                case 0:
                    $this->setModel($endpointRequest, $segment);
                    break;
                case 1:
                case 3:
                    $this->setCustomMethod($endpointRequest, $segment);
                    break;
                case 2:
                    $this->setRelationModel($endpointRequest, $segment);
                    break;
                case 4:
                    $endpointRequest->setId($segment);
//   TODO             default
            }
        }
    }

    private function setCustomMethod(Request $endpointRequest, ?string $segment): void
    {
        $endpointsClass = $this->endpointsNamespace . '\\' . ucwords(Str::singular($endpointRequest->getRelation())) . 'Endpoints';
        if (!class_exists($endpointsClass) || !method_exists($endpointsClass, $segment)) {
            $endpointsClass = Endpoints::class;
            $endpointRequest->setId($segment);
        } else {
            $endpointRequest->setCustomMethod($segment);
        }

        $endpointRequest->setEndpoint(new $endpointsClass($this->model));
    }

    private function setRelationModel(Request $endpointRequest, ?string $segment): void
    {
        if (!in_array($segment, $this->model::getModelMetadata()->getRelationNames())) {
            $endpointRequest->setId($segment);
        } else {
            $modelMetadata = $this->model::getModelMetadata();
            $relationClass = $modelMetadata->getRelationsData()[$segment];
            $endpointRequest->setRelation($relationClass);
        }
    }

    private function setModel(Request $endpointRequest, ?string $segment): void
    {
        $modelName = config('namespaces.models') .'\\' . ucwords(Str::singular($segment));
        $this->model = new $modelName();
        $endpointRequest->setModel($this->model);
    }

}
