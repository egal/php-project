<?php

namespace App\egal;

class ModelMetadata
{

    protected array $fields;
    protected array $relations;

    /**
     * Method for creating the model's metadata object.
     *
     * @return self
     */
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

    /**
     * Set relations metadata for model.
     *
     * @param RelationMetadata ...$relationsMetadata
     *
     * @return self
     */
    public function setRelations(RelationMetadata ...$relationsMetadata):self
    {
        $this->relations = $relationsMetadata;

        return $this;
    }

    /**
     * Get validation rules of attributes.
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        $validationRules = [];
        /** @var FieldMetadata $field */
        foreach ($this->fields as $field) {
            $validationRules[] = [
                $field->getName() => $field->getValidationRules()
            ];
        }

        return $validationRules;
    }
}
