<?php

namespace App\egal;

class FieldMetadata
{
    use FieldTypeTrait, FieldRequiredTrait;

    public static function make(string $name): self
    {
    }
}
