<?php

namespace Egal\Core\Rest\Filter;

class Field
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $field): Field
    {
        return new self($field);
    }

    public function getName(): string
    {
        return $this->name;
    }

}
