<?php

namespace Egal\Core;

class TableRelation
{
    protected string $relationName;

    public static function make(): self
    {
        return new self();
    }

    public function setName(string $relationName): self
    {
        $this->relationName = $relationName;

        return $this;
    }

    public function getName(): string
    {
        return $this->relationName;
    }
}