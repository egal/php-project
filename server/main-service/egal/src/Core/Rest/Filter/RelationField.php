<?php

namespace Egal\Core\Rest\Filter;

class RelationField
{
    protected string $name;
    protected string $relation;

    public function __construct(string $name, string $relation)
    {
        $this->name = $name;
        $this->relation = $relation;
    }

    public static function fromString(string $fieldString): RelationField
    {
        $fieldParts = explode('.', $fieldString);
        return new self(array_pop($fieldParts), array_pop($fieldParts));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

}
