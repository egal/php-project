<?php

namespace Egal\Core;

class TableField
{
    protected FieldMetadata $fieldMetadata;

    public static function make(FieldMetadata $fieldName):self
    {
    }

    public function setLabel():self
    {
    }

    public function setComputed():self
    {
    }
}