<?php

namespace Egal\Core\Rest\Filter;

class Condition
{

    use Combinable;

    private string $field;
    private Operator $operator;
    private null|bool|int|float|string $value;

    public static function make(
        string                     $field,
        Operator                   $operator,
        null|bool|int|float|string $value,
        Combiner                   $combiner = Combiner::And
    ): static
    {
        $condition = new static();
        $condition->field = $field;
        $condition->operator = $operator;
        $condition->value = $value;
        $condition->combiner = $combiner;

        return $condition;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOperator(): Operator
    {
        return $this->operator;
    }

    public function getValue(): float|bool|int|string|null
    {
        return $this->value;
    }

}
