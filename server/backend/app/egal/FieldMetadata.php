<?php

namespace App\egal;

class FieldMetadata
{
    use FieldTypeTrait, FieldRequiredTrait, FieldProhibitedTrait, FieldExcludeTrait, FieldSwitchOptionTrait;

    protected string $fieldName;
    protected ?array $customValidationRules;

    /**
     * Method for creating attribute metadata.
     *
     * @return self
     */
    public static function make(): self
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

    /**
     * Set custom validation rules for attribute.
     *
     * @param array $customValidationRules List of custom validation rules.
     *
     * @return self
     */
    public function setCustomValidationRules(array $customValidationRules): self
    {
        $this->customValidationRules = $customValidationRules;

        return $this;
    }

    /**
     * Get name of attribute.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->fieldName;
    }

    /**
     * Get custom validation rules of attribute.
     *
     * @return array|null
     */
    public function getCustomValidationRules(): ?array
    {
        return $this->customValidationRules;
    }

    /**
     * Get validation rules of attribute.
     *
     * @return array|string|null
     */
    public function getValidationRules(): array|string|null
    {
        $validationRules = array_filter([
            $this->getRequiredRules(),
            $this->getType(),
            $this->getProhibitedRules(),
            $this->getExcludeRules(),
            $this->getAcceptedRules(),
            $this->getDateRules()
        ]);

        if ($customRules = $this->customValidationRules) {
            return array_merge($validationRules, $customRules);
        }

        return implode('|', $validationRules);
    }
}
