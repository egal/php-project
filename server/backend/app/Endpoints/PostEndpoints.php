<?php

namespace App\Endpoints;

use App\egal\EgalEndpoints;
use App\Models\Post;

class PostEndpoints extends EgalEndpoints
{
    protected string $modelClass = Post::class;

    public function endpointUpdateCustom()
    {
        // получение запроса и вызов контроллера по типу работы ActionCaller
        // кастомная логика форматирования, преобр-я и получения данных, вызов БЛ из модели
    }
}
