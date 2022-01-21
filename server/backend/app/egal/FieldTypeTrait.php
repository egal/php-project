<?php

namespace App\egal;

trait FieldTypeTrait
{
    use FieldDateTrait, FieldStringFormatTrait, FieldStringValueTrait;

    protected string $type;

    /**
     * Set attribute to string type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isString():self
    {
        $this->type = FieldTypeConsts::STRING;

        return $this;
    }

    /**
     * Set attribute to int type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isInt():self
    {
        $this->type = FieldTypeConsts::INT;

        return $this;
    }

    /**
     * Set attribute to float type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isFloat():self
    {
        $this->type = FieldTypeConsts::FLOAT;

        return $this;
    }

    /**
     * Set attribute to boolean type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isBool():self
    {
        $this->type = FieldTypeConsts::BOOL;

        return $this;
    }

    /**
     * Set attribute to numeric type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isNumeric():self
    {
        $this->type = FieldTypeConsts::NUMERIC;

        return $this;
    }

    /**
     * Set attribute to array type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isArray():self
    {
        $this->type = FieldTypeConsts::ARRAY;

        return $this;
    }

    /**
     * Set attribute to file type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isFile():self
    {
        $this->type = FieldTypeConsts::FILE;

        return $this;
    }

    /**
     * Set attribute to date type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isDate():self
    {
        $this->type = FieldTypeConsts::DATE;

        return $this;
    }

    /**
     * Set attribute to image type.
     *
     * @return FieldMetadata|FieldTypeTrait
     */
    public function isImage():self
    {
        $this->type = FieldTypeConsts::IMAGE;

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
