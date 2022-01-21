<?php

namespace App\egal;

class ModelMetadata
{
    protected array $fields;

    public static function make():self
    {
        return new self();
    }

    /**
     * Set fields metadata for model.
     *
     * @param FieldMetadata ...$fieldsMetadata
     *
     * @return self
     */
    public function setFields(FieldMetadata ...$fieldsMetadata):self
    {
        $this->fields = $fieldsMetadata;

        return $this;
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

    public function getFieldNames(): array
    {
        $fieldNames = [];
       foreach ($this->fields as $field) {
           $fieldNames[] = $field->getName();
       }
       return $fieldNames;
    }
}
