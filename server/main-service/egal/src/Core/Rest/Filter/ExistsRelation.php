<?php

namespace Egal\Core\Rest\Filter;

class ExistsRelation extends AbstractField
{
    protected string $relation;

    public function __construct(string $relation)
    {
        $this->relation = $relation;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public static function fromString(string $fieldString): AbstractField
    {
        // TODO: Implement fromString() method.
    }
}
