<?php

namespace Egal\Core;

use Exception;

class EgalCoreInitializationException extends Exception
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