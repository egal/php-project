<?php

namespace App\egal;

class ModelMetadata
{

    public static function make(string $string):self
    {
    }

    public function fields(...$fieldsMetadata):self
    {
    }

    public function relations(...$relationsMetadata):self
    {
    }

    public function allowEndpoints(array $array):self
    {
    }

    public function getValidationRules(): array
    {

    }
}
