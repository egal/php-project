<?php

namespace App\egal;

trait FieldExcludeTrait
{
    protected ?string $exclude;
    protected ?string $excludeIf;
    protected ?string $excludeUnless;
    protected ?string $excludeWithout;

    /**
     * Set exclude attribute.
     *
     * @return FieldMetadata|FieldExcludeTrait
     */
    public function setExclude():self
    {
        $this->exclude = 'exclude';

        return $this;
    }

    /**
     * Set option exclude_if attribute.
     *
     * @param string $anotherField
     * @param mixed $value
     *
     * @return FieldMetadata|FieldExcludeTrait
     */
    public function setExcludeIf(string $anotherField, mixed $value):self
    {
        $this->excludeIf = 'exclude_if:' . $anotherField . ',' . $value;

        return $this;
    }

    /**
     * Set option exclude_unless attribute.
     *
     * @param string $anotherField
     * @param mixed $value
     *
     * @return FieldMetadata|FieldExcludeTrait
     */
    public function setExcludeUnless(string $anotherField, mixed $value):self
    {
        $this->excludeUnless = 'exclude_unless:' . $anotherField . ',' . $value;

        return $this;
    }

    /**
     * Set option exclude_without attribute.
     *
     * @param string $anotherField
     *
     * @return FieldMetadata|FieldExcludeTrait
     */
    public function setExcludeWithout(string $anotherField):self
    {
        $this->excludeWithout = 'exclude_without:' . $anotherField;

        return $this;
    }

    /**
     * Get all exclude options of attribute.
     *
     * @return array
     */
    public function getExcludeRules():array
    {
        return array_filter([
            $this->exclude,
            $this->excludeIf,
            $this->excludeUnless,
            $this->excludeWithout,
        ]);
    }
}