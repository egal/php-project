<?php

namespace Egal\InterfaceMetadata\Facades;

use Illuminate\Support\Facades\Facade;

class Manager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'egal.interface.metadata.manager';
    }
}
