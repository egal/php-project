<?php

namespace App\egal;

trait FieldTypeTrait
{
    protected string $type;

    /**
     * Set attribute to string type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function string():self
    {
        $this->type = FieldTypeConsts::STRING;

        return $this;
    }

    /**
     * Set attribute to int type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function int():self
    {
        $this->type = FieldTypeConsts::INT;

        return $this;
    }

    /**
     * Set attribute to float type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function float():self
    {
        $this->type = FieldTypeConsts::FLOAT;

        return $this;
    }

    /**
     * Set attribute to boolean type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function bool():self
    {
        $this->type = FieldTypeConsts::BOOL;

        return $this;
    }

    /**
     * Get attribute type.
     *
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }
}
