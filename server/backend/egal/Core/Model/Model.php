<?php

namespace Egal\Core\Model;

use Egal\Core\Model\Metadata\ModelMetadata;
use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class Model extends LaravelModel
{
    abstract static function getModelMetadata():ModelMetadata;

    public function getName(): string
    {
        $reflectionClass = new \ReflectionClass($this);
        return $reflectionClass->getShortName();
    }
}
