<?php

namespace Egal\Core\Auth;

use Exception;

class InitializeUserServiceTokenException extends Exception
{
    protected $message = 'Initialize user service token exception!';

    protected $code = 400;
}