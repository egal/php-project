<?php

namespace Egal\Core\Interface;

class TableField
{
    protected string $name;
    protected string $label;
    protected array $computed;

    public static function make(string $fieldName):self
    {
        $tableField = new self();
        $tableField->name = $fieldName;
        $tableField->label = $fieldName;

        return $tableField;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setLabel(string $label):self
    {
        $this->label = $label;

        return $this;
    }

    public function setComputed(array $computed):self
    {
        $this->computed = $computed;

        return $this;
    }
}