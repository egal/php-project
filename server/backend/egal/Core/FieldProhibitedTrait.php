<?php

namespace App\egal;

trait FieldProhibitedTrait
{
    protected ?string $prohibited;
    protected ?string $prohibitedIf;
    protected ?string $prohibitedUnless;
    protected ?string $prohibits;

    /**
     * Set prohibited attribute.
     *
     * @return FieldMetadata|FieldProhibitedTrait
     */
    public function setProhibited():self
    {
        $this->prohibited = 'prohibited';

        return $this;
    }

    /**
     * Set option prohibited_if attribute.
     *
     * @param string $anotherField
     * @param mixed ...$value
     *
     * @return FieldMetadata|FieldProhibitedTrait
     */
    public function setProhibitedIf(string $anotherField, mixed ...$value):self
    {
        $this->prohibitedIf = 'prohibited_if:' . $anotherField . ',' . implode(',', $value);

        return $this;
    }

    /**
     * Set option prohibited_unless attribute.
     *
     * @param string $anotherField
     * @param mixed ...$value
     *
     * @return FieldMetadata|FieldProhibitedTrait
     */
    public function setProhibitedUnless(string $anotherField, mixed ...$value):self
    {
        $this->prohibitedUnless = 'prohibited_unless:' . $anotherField . ',' . implode(',', $value);

        return $this;
    }

    /**
     * Set option prohibits attribute.
     *
     * @param string ...$anotherField
     *
     * @return FieldMetadata|FieldProhibitedTrait
     */
    public function setProhibits(string ...$anotherField):self
    {
        $this->prohibits = 'prohibits:' . implode(',', $anotherField);

        return $this;
    }

    /**
     * Get prohibited options.
     *
     * @return array
     */
    public function getProhibitedRules():array
    {
        return array_filter([
            $this->prohibited,
            $this->prohibitedIf,
            $this->prohibitedUnless,
            $this->prohibits,
        ]);
    }
}