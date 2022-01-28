<?php

namespace Egal\Core;

class ReadingStudFileException extends \Exception
{
    protected $message = 'Error reading stub file!';

    protected $code = 500;
}