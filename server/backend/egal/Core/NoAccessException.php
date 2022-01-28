<?php

namespace Egal\Core;

use Exception;

class NoAccessException extends Exception
{
    protected $code = 403;

}