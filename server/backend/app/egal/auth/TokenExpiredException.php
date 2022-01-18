<?php

namespace App\egal\auth;

use Exception;
use Illuminate\Support\Str;

class TokenExpiredException extends Exception
{

    protected $code = 401;


    public static function make(string $tokenType): self
    {
        $result = new static();
        $result->message = 'Token ' . Str::upper($tokenType) . ' expired!';

        return $result;
    }

}