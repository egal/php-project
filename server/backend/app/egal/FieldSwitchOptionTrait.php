<?php

namespace App\egal;

trait FieldSwitchOptionTrait
{
    protected ?string $accepted;
    protected ?string $declined;
    protected ?string $acceptedIf;
    protected ?string $declinedIf;

    /**
     * Set accepted for attribute.
     *
     * @return FieldSwitchOptionTrait|FieldMetadata
     */
    public function setAccepted():self
    {
        $this->accepted = 'accepted';
        $this->declined = '';

        return $this;
    }

    /**
     * Set declined for attribute.
     *
     * @return FieldSwitchOptionTrait|FieldMetadata
     */
    public function setDeclined():self
    {
        $this->declined = 'declined';
        $this->accepted = '';

        return $this;
    }

    /**
     * Set option accepted_if for attribute.
     *
     * @param string $anotherField
     * @param mixed ...$value
     *
     * @return FieldSwitchOptionTrait|FieldMetadata
     */
    public function setAcceptedIf(string $anotherField, mixed ...$value):self
    {
        $this->acceptedIf = 'accepted_if:' . $anotherField . ',' . implode(',', $value);
        $this->declinedIf = '';

        return $this;
    }

    /**
     * Set option declined_if for attribute.
     *
     * @param string $anotherField
     * @param mixed ...$value
     *
     * @return FieldSwitchOptionTrait|FieldMetadata
     */
    public function setDeclinedIf(string $anotherField, mixed ...$value):self
    {
        $this->declinedIf = 'declined_if:' . $anotherField . ',' . implode(',', $value);
        $this->acceptedIf = '';

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
            $this->acceptedIf,
            $this->declined,
            $this->declinedIf
        ]);
    }
}