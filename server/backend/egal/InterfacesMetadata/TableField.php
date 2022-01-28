<?php

namespace Egal\Core\Interface;

class TableField
{
    protected string $fieldName;

    public static function make(string $fieldName):self
    {
        $tableField = new self();
        $tableField->fieldName = $fieldName;

        return $tableField;
    }

    public function getName(): string
    {
        return $this->fieldName;
    }

    public function setLabel():self
    {
    }

    public function setComputed():self
    {
    }
}