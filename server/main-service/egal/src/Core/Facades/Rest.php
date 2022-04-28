<?php

namespace Egal\Core\Facades;

use Egal\Core\Rest\Controller;
use Egal\Core\Rest\Filter\Query as FilterQuery;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array index(string $modelClass, ?FilterQuery $filter = null)
 * @method static void create(string $modelClass, array $attributes = [])
 * @method static array show(string $modelClass, $key)
 * @method static void update(string $modelClass, $key, array $attributes = [])
 * @method static void delete(string $modelClass, $key)
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
