<?php

namespace Egal\Core;

use Illuminate\Http\Request as LaravelRequest;


class Request
{

    protected Model $model;
    protected string $httpMethod;
    protected $id;
    protected Endpoints $endpoint;
    protected string $endpointMethod;
    protected Model $relation;

    const ENDPOINT_METHODS = [
      'with_id' => [
          'GET' => 'show',
          'PUT' => 'update',
          'DELETE' => 'delete'
      ],
      'without_id' => [
          'GET' => 'index',
          'POST' => 'create'
      ]
    ];

    public function call(): array
    {
        // обработка ошибок
        $endpointMethod = 'endpoint' . ucwords(isset($this->id)
            ? self::ENDPOINT_METHODS['with_id'][$this->httpMethod]
            : self::ENDPOINT_METHODS['without_id'][$this->httpMethod]);
        $endpointMethod .= ucwords($this->endpointMethod) ?? '';
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

    public function getId()
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
    public function getEndpointMethod(): string
    {
        return $this->endpointMethod;
    }

    public function setHttpMethod(string $methodName)
    {
        $this->httpMethod = $methodName;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEndpointMethod($endpointMethod)
    {
        $this->endpointMethod = $endpointMethod;
    }

    public function setEndpoint(Endpoints $endpointsClass)
    {
        $this->endpoint = $endpointsClass;
    }

    public function setRelation(Model $relation)
    {
        $this->relation = $relation;
    }

    public function toArray() : array
    {
        $result = [];
        foreach (array_keys(get_object_vars($this)) as $field) {
            $value = $this->{'get' . ucfirst($field)}();
            if (is_null($value)) {
                continue;
            }

            $result[$field] = $value;
        }

        return $result;
    }

}