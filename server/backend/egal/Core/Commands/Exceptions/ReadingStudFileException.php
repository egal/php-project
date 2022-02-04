<?php

namespace Egal\Core\Commands\Exceptions;

class ReadingStudFileException extends \Exception
{
    protected $message = 'Error reading stub file!';

    protected $code = 500;
}