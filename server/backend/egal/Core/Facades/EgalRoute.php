<?php

namespace Egal\Core\Facades;

use Illuminate\Support\Facades\Facade;

class EgalRoute extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'EgalRoute';
    }

}
