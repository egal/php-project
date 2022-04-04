<?php

namespace Egal\Core\Facades;

use Egal\Core\Rest\Controller;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array index(string $modelClass, array $filter = [])
 * @method static void create(string $modelClass, array $attributes = [])
 *
 * @see Controller
 */
class Rest extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'EgalRest';
    }

}
