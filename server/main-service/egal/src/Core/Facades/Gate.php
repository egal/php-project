<?php

namespace Egal\Core\Facades;

use Egal\Core\Auth\User;
use Egal\Core\Interfaces\Gate as GateInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Egal\Core\Auth\Gate
 */
class Gate extends Facade
{

    protected static function getFacadeAccessor()
    {
        return GateInterface::class;
    }

    public static function user(): User
    {
        return self::getUser();
    }

}
