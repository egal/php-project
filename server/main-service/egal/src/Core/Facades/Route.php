<?php

namespace Egal\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Route extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'EgalRoute';
    }

}
