<?php

namespace App\Endpoints;

use App\Models\Post;
use Egal\Core\Model\Endpoints;

class PostEndpoints extends Endpoints
{
    protected string $modelClass = Post::class;

    public function endpointUpdateCustom()
    {
        // получение запроса и вызов контроллера по типу работы ActionCaller
        // кастомная логика форматирования, преобр-я и получения данных, вызов БЛ из модели
    }
}
