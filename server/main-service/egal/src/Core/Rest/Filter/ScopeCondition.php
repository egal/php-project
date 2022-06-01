<?php

namespace Egal\Core\Rest\Filter;

class ScopeCondition
{
    use Combinable;

    public const REG_PATTERN = '(?<scope>[a-zA-Z]+)\((?<parameters>[^)]*)\)';
    public const PARAMETER_REG_PATTERN = '/(?<key>\w+)\s*=\s*(\'?)(?<value>(?:\w+[-+*%\']*)*?\w+)\b\2/m';

    protected string $name;
    protected array $parameters;

    public static function make(string $name, array $parameters)
    {
        $condition = new static();
        $condition->name = $name;
        $condition->parameters = $parameters;

        return $condition;
    }
}
