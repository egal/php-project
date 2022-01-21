<?php

namespace App\egal;

class FieldMetadata
{
    use FieldTypeTrait, FieldRequiredTrait;

    protected string $fieldName;

    public static function make():self
    {
        return new self();
    }

    /**
     * Set name of attribute.
     *
     * @param string $fieldName Name of attribute.
     *
     * @return self
     */
    public function setName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getName(): string
    {
        return $this->fieldName;
    }
}
