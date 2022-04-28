<?php

namespace Egal\Core\Rest\Filter;

class Field
{
    protected string $name;
    protected ?string $relation;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $fieldString): Field
    {
        $fieldParts = explode('.', $fieldString);
        $field = new self(array_pop($fieldParts));

        if (!empty($fieldParts)) {
            $field->setRelation(array_pop($fieldParts));;
        }

        return $field;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRelation(): ?string
    {
        return $this->relation ?? null;
    }

    public function setRelation(?string $relation): void
    {
        $this->relation = $relation;
    }
}
