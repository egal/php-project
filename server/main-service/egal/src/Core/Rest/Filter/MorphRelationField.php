<?php

namespace Egal\Core\Rest\Filter;

class MorphRelationField extends AbstractField
{
    public const REG_PATTERN = "(?<morph_relation>[a-z_]+)\[(?<types>([a-z_,]+))\]\.(?<morph_relation_field>[a-z_]+)";
    public const TYPES_DELIMITER = ",";

    protected string $relation;
    protected array  $types;
    protected string $field;

    public function __construct(string $field, string $relation, array $types)
    {
        $this->field = $field;
        $this->relation = $relation;
        $this->types = $types ?? [];
    }

    public static function fromString(string $fieldString): MorphRelationField
    {

    }


    public function getField(): string
    {
        return $this->field;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function getTypes(): array
    {
        return $this->types;
    }
}
