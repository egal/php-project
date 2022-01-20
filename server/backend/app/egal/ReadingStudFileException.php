<?php

namespace App\egal;

class ReadingStudFileException extends \Exception
{
    protected $message = 'Error reading stub file!';

    protected $code = 500;
}