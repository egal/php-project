<?php

namespace App\egal;

trait FieldAcceptedTrait
{
    protected ?string $accepted;
    protected ?string $acceptedIf;

    /**
     * Set accepted attribute.
     *
     * @return FieldAcceptedTrait|FieldMetadata
     */
    public function setAccepted():self
    {
        $this->accepted = 'accepted';

        return $this;
    }

    /**
     * Set option accepted_if attribute.
     *
     * @param string $anotherField
     * @param mixed ...$value
     *
     * @return FieldAcceptedTrait|FieldMetadata
     */
    public function setAcceptedIf(string $anotherField, mixed ...$value):self
    {
        $this->acceptedIf = 'accepted_if:' . $anotherField . ',' . implode(',', $value);

        return $this;
    }

    /**
     * Get all accepted rules of attribute.
     *
     * @return array
     */
    public function getAcceptedRules():array
    {
        return array_filter([
            $this->accepted,
            $this->acceptedIf
        ]);
    }
}