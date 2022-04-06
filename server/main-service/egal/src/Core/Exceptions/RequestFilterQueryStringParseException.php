<?php

namespace Egal\Core\Exceptions;

use Exception;

class RequestFilterQueryStringParseException extends Exception
{

    protected $message = 'Query parameter \'filter\' parsing error!';

    protected $code = 400;

    public static function make(string $error): self
    {
        $exception = new static();
        $exception->message .= PHP_EOL . $error;

        return $exception;
    }

}
