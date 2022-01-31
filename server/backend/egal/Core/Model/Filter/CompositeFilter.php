<?php

namespace Egal\Core\Model\Filter;

class CompositeFilter implements FilterInterface
{

    protected FilterInterface $param;
    protected string $operator;
    protected FilterInterface $value;
    protected string $operatorAfter = 'AND';

    public static function make(): self
    {
        return new self();
    }

    public function setParam(FilterInterface $param): self
    {
        $this->param = $param;

        return $this;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function setValue(FilterInterface $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setOperatorAfter(string $operatorAfter): self
    {
        $this->operatorAfter = $operatorAfter;

        return $this;
    }
}