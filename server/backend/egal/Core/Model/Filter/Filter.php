<?php

namespace Egal\Core\Model\Filter;

class Filter implements FilterInterface
{

    protected string $param;
    protected string $operator;
    protected string $value;
    protected string $operatorAfter = 'AND';

    public static function make(): self
    {
        return new self();
    }

    public function setParam(string $param): self
    {
        $this->param = $param;

        return $this;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function setValue(string $value): self
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