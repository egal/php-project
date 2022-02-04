<?php

namespace Egal\Core\Model\Metadata;

use Exception;

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

    /**
     * Set relations metadata for model.
     *
     * @param RelationMetadata ...$relationsMetadata
     *
     * @return self
     */
    public function setRelations(...$relationsMetadata):self
    {
        $this->relations = $relationsMetadata;

        return $this;
    }

    public function getFieldByName(string $fieldName): FieldMetadata
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $fieldName) {
                return $field;
            }
        }

        // TODO: СДелать эксепшн для этого случая
        throw new Exception();
    }

    public function getRelationByName(string $relationName): RelationMetadata
    {
        foreach ($this->relations as $relation) {
            if ($relation->getName() === $relationName) {
                return $relation;
            }
        }

        // TODO: СДелать эксепшн для этого случая
        throw new Exception();
    }

    public function getFieldValidationRules(): array
    {
        $fieldNames = [];
        foreach ($this->fields as $field) {
            $fieldNames[] = $field->getValidationRules();
        }

        return $fieldNames;
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
