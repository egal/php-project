<?php

namespace Egal\Core\Facades;

use Egal\Core\Auth\Manager;
use Egal\Core\Auth\User;
use Illuminate\Support\Facades\Facade;

/**
 * @method static User authenticate(string $jwt)
 *
 * @see Manager
 */
class Auth extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'EgalAuth';
    }

    public static function user(): ?User
    {
        return self::getUser();
    }

}
