<?php

namespace Egal\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array index(string $modelClass, array $filter = [])
 * @method static void create(string $modelClass, array $attributes = [])
 */
class Rest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'EgalRest';
    }

}
