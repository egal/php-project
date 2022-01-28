<?php

namespace Egal\Core\Auth;

use Exception;

class UserServiceTokenException extends Exception
{
    protected $message = 'User service token exception!';

    protected $code = 500;
}