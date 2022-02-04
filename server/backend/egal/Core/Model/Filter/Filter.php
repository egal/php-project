<?php

namespace Egal\Core\Model\Filter;

class Filter implements FilterInterface
{

    protected string $param;
    protected string $operator;
    protected string $value;
    protected string $operatorAfter;

    public static function make(string $param, string $operator, string $value, string $operatorAfter = 'and'): self
    {
        $filter = new self();
        $filter->param = $param;
        $filter->operator = $operator;
        $filter->value = $value;
        $filter->operatorAfter = $operatorAfter;

        return $filter;
    }

    public function getParam(): string
    {
        return $this->param;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOperatorAfter(): string
    {
        return $this->operatorAfter;
    }

}