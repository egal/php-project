<?php

namespace Egal\Core\Rest\Filter;

class Condition
{
    protected Combiner $combiner;
    protected string $field;
    protected Operator $operator;
    protected string $value;

    public function __construct(string $field, Operator $operator, string $value, Combiner $combiner = Combiner::And)
    {
        $this->combiner = $combiner;
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOperator(): Operator
    {
        return $this->operator;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCombiner(): Combiner
    {
        return $this->combiner;
    }

}
