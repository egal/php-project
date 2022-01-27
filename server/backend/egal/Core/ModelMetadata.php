<?php

namespace Egal\Core;
class ModelMetadata
{
    protected string $modelName;
    protected array $fields;
    protected array $relations;

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

    public function setRelations(...$relationsMetadata):self
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

    public function getRelationNames(): array
    {
        $relationNames = [];
        foreach ($this->relations as $relation) {
            $relationNames[] = $relation->getName();
        }
        return $relationNames;
    }

    public function getRelationsData(): array
    {
        $relationData = [];
        foreach ($this->relations as $relation) {
            $relationData[$relation->getName()] = $relation->getClass();
        }
        return $relationData;
    }
}
