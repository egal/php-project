<?php

namespace Egal\Core;

use Egal\Core\Routes\EndpointMethod;
use Exception;

class Request
{

    use Arrayable;

    protected Model $model;
    protected string $httpMethod;
    protected int|string $id;
    protected Endpoints $endpoint;
    protected string $customMethod;
    protected Model $relation;

    /**
     * @throws Exception
     */
    public function call(): array
    {
        // обработка ошибок
        $endpointMethod = 'endpoint' . ucfirst(EndpointMethod::getEndpointMethod($this->httpMethod, isset($this->id)));
        $endpointMethod .= ucwords($this->customMethod) ?? '';

        return $this->endpoint->$endpointMethod();
    }


    public function getModel(): Model
    {
        return $this->model;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getRelation(): Model
    {
        return $this->relation;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @return Endpoints
     */
    public function getEndpoint(): Endpoints
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getCustomMethod(): string
    {
        return $this->customMethod;
    }

    public function setHttpMethod(string $methodName): void
    {
        $this->httpMethod = $methodName;
    }

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setCustomMethod($customMethod): void
    {
        $this->customMethod = $customMethod;
    }

    public function setEndpoint(Endpoints $endpointsClass): void
    {
        $this->endpoint = $endpointsClass;
    }

    public function setRelation(Model $relation): void
    {
        $this->relation = $relation;
    }

}