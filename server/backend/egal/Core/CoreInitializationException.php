<?php

namespace Egal\Core;

use Exception;

class CoreInitializationException extends Exception
{

    /**
     * The error message
     */
    protected $message = 'Egal Core initialization exception!';

    /**
     * The error code
     */
    protected $code = 500;
}