<?php

namespace Egal\Core;

use Illuminate\Http\Request as LaravelRequest;


class Request extends LaravelRequest
{

    public function getModelInstanse(): Model
    {
        // нужен класс хелпер для установки верных namespace, если внутри все по папкам, например
        $modelName = 'App\Models\\' . ucwords($this->segments()[0]);
        // парсинг запроса
        return new $modelName();
    }

    public function getEndpointClass(): Endpoints
    {
        // нужен класс хелпер для установки верных namespace, если внутри все по папкам, например
        $endpointName = 'App\Endpoints\\' . ucwords($this->segments()[1]);
        // парсинг запроса
        return new $endpointName();
    }

    public function getMethodName(): string
    {

    }
}