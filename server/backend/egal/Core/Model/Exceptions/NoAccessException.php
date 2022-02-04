<?php

namespace Egal\Core\Model\Exceptions;

use Exception;

class NoAccessException extends Exception
{
    protected $code = 403;

}