<?php

namespace Egal\Core\Auth;

use Exception;

class UnableDecodeTokenException extends Exception
{

    protected $message = 'Unable to decode token!';

    protected $code = 401;

}