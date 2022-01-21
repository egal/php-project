<?php

namespace Egal\Core;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EgalRequest extends Request
{

    public function getModelInstanse(): EgalModel
    {
        // нужен класс хелпер для установки верных namespace, если внутри все по папкам, например
        $modelName = 'App\Models\\' . ucwords($this->segments()[0]);
        // парсинг запроса
        return new $modelName();
    }
}