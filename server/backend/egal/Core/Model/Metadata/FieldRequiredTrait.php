<?php

namespace Egal\Core\Model\Metadata;

trait FieldRequiredTrait
{
    protected ?string $required;
    protected ?string $requiredIf;
    protected ?string $requiredUnless;
    protected ?string $requiredWith;
    protected ?string $requiredWithAll;
    protected ?string $requiredWithout;
    protected ?string $requiredWithoutAll;

    /**
     * Set required attribute.
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequired():self
    {
        $this->required = 'required';

        return $this;
    }

    /**
     * Set option required_if for attribute.
     *
     * @param string $anotherField
     * @param mixed  ...$value
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredIf(string $anotherField, mixed ...$value):self
    {
        $this->requiredIf = 'required_if:' . $anotherField . ',' . implode(',', $value);

        return $this;
    }

    /**
     * Set option required_unless for attribute.
     *
     * @param string $anotherField
     * @param mixed  ...$value
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredUnless(string $anotherField, mixed ...$value):self
    {
        $this->requiredUnless = 'required_unless:' . $anotherField . ',' . implode(',', $value);

        return $this;
    }

    /**
     * Set option required_with for attribute.
     *
     * @param string $checkedField
     * @param string  ...$anotherFields
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredWith(string $checkedField, string ...$anotherFields):self
    {
        $this->requiredWith = 'required_with:' . $checkedField . ',' . implode(',', $anotherFields);

        return $this;
    }

    /**
     * Set option required_with_all for attribute.
     *
     * @param string $checkedField
     * @param string  ...$anotherFields
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredWithAll(string $checkedField, string ...$anotherFields):self
    {
        $this->requiredWithAll = 'required_with_all:' . $checkedField . ',' . implode(',', $anotherFields);

        return $this;
    }

    /**
     * Set option required_without for attribute.
     *
     * @param string $checkedField
     * @param string  ...$anotherFields
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredWithout(string $checkedField, string ...$anotherFields):self
    {
        $this->requiredWithout = 'required_without:' . $checkedField . ',' . implode(',', $anotherFields);

        return $this;
    }

    /**
     * Set option required_without_all for attribute.
     *
     * @param string $checkedField
     * @param string  ...$anotherFields
     *
     * @return FieldMetadata|FieldRequiredTrait
     */
    public function setRequiredWithoutAll(string $checkedField, string ...$anotherFields):self
    {
        $this->requiredWithoutAll = 'required_without_all:' . $checkedField . ',' . implode(',', $anotherFields);

        return $this;
    }

    public function getRequiredRules(): array
    {
        return array_filter(
            [
                $this->required,
                $this->requiredIf,
                $this->requiredWith,
                $this->requiredUnless,
                $this->requiredWithAll,
                $this->requiredWithout,
                $this->requiredWithoutAll,
            ]
        );
    }
}
