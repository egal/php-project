<?php

namespace Egal\Core;

class ModelMetadata
{
    protected string $modelName;
    protected array $fields;

    public static function make(string $modelName):self
    {
        $modelMetadata = new self();
        $modelMetadata->modelName = $modelName;

        return $modelMetadata;
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

    public function getFieldsData(): array
    {
        $fieldsData = [];
        foreach ($this->fields as $field) {
            $fieldsData[$field->getName()] = $field->getType();
        }
        return $fieldsData;
    }
}
