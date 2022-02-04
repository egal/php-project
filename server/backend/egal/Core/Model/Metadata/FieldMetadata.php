<?php

namespace Egal\Core\Model\Metadata;

class FieldMetadata
{
    use FieldTypeTrait, FieldRequiredTrait;

    protected string $fieldName;

    public static function make(string $fieldName):self
    {
        $fieldMetadata = new self();
        $fieldMetadata->fieldName = $fieldName;

        return $fieldMetadata;
    }

    public function getName(): string
    {
        return $this->fieldName;
    }
}
