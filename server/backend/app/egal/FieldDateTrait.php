<?php

namespace App\egal;

trait FieldDateTrait
{
    protected ?string $after;
    protected ?string $before;
    protected ?string $afterOrEqual;
    protected ?string $beforeOrEqual;
    protected ?string $dateEquals;
    protected ?string $dateFormat;

    /**
     * Set option after for date.
     *
     * @param string $date
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setAfter(string $date):self
    {
        $this->after = 'after:' . $date;

        return $this;
    }

    /**
     * Set option after_or_equal for date.
     *
     * @param string $date
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setAfterOrEqual(string $date):self
    {
        $this->afterOrEqual = 'after_or_equal:' . $date;

        return $this;
    }

    /**
     * Set option before for date.
     *
     * @param string $date
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setBefore(string $date):self
    {
        $this->before = 'before:' . $date;

        return $this;
    }

    /**
     * Set option before_or_equal for date.
     *
     * @param string $date
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setBeforeOrEqual(string $date):self
    {
        $this->beforeOrEqual = 'before_or_equal:' . $date;

        return $this;
    }

    /**
     * Set option date_equals for date.
     *
     * @param string $date
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setDateEquals(string $date):self
    {
        $this->dateEquals = 'date_equals:' . $date;

        return $this;
    }

    /**
     * Set option date_format for date.
     * You should use either FieldTypeTrait::isDate or this method for attribute, not both.
     * See: https://laravel.com/docs/8.x/validation#rule-date-format
     *
     * @param string $format
     *
     * @return FieldDateTrait|FieldMetadata
     */
    public function setDateFormat(string $format):self
    {
        if (! $this->isDate()) {
            $this->dateFormat = 'date_format:' . $format;
        }

        return $this;
    }

    /**
     * Get date rules for attribute.
     *
     * @return array
     */
    public function getDateRules():array
    {
        return [
            $this->after,
            $this->afterOrEqual,
            $this->before,
            $this->beforeOrEqual,
            $this->dateEquals,
            $this->dateFormat
        ];
    }
}