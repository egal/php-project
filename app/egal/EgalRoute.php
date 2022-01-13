<?php

namespace App\egal;

use Illuminate\Routing\PendingResourceRegistration;

class EgalRoute
{

    public static function resource(string $resource, string $controller, array $options = []): PendingResourceRegistration
    {
        // работает с index, create, show ....
    }

    public static function morphToManyResource(string $resource, string $relation, string $controller, array $options = []): PendingResourceRegistration
    {
        // работает с relationIndex, relationCreate, relationShow ....
    }
}
