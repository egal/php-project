<?php

namespace Egal\Core\Interface;

use Egal\Core\Traits\Arrayable;

class TableFilter
{
    use Arrayable;

    protected string|array $param;
    protected string $operator;
    protected string|array $value;

    public static function make(): self
    {
        return new self();
    }

    // TODO: точно проверить, что на этапе toArray у $param нет уже вложенных TableField
    public function setParam(string|TableFilter $param): self
    {
        $this->param = is_string($param) ? $param : $param->toArray();

        return $this;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function setValue(string|TableFilter $value): self
    {
        $this->value = is_string($value) ? $value : $value->toArray();;

        return $this;
    }

    public function getParam(): string|array
    {
        return $this->param;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): string|array
    {
        return $this->value;
    }
}