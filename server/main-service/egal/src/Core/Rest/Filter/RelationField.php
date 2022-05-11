<?php

namespace Egal\Core\Rest\Filter;

class RelationField extends AbstractField
{
    protected string $relation;
    protected string $field;

    public function __construct(string $field, string $relation)
    {
        $this->field = $field;
        $this->relation = $relation;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public static function fromString(string $fieldString): RelationField
    {
        $fieldParts = explode('.', $fieldString);
        return new self(array_pop($fieldParts), array_pop($fieldParts));
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

}
