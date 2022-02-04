<?php

namespace Egal\Core\Interface;

class TableRelation
{
    protected string $name;

    public static function make(string $relationName): self
    {
        $tableField = new self();
        $tableField->name = $relationName;

        return $tableField;
    }

    public function getName(): string
    {
        return $this->name;
    }
}