<?php

namespace Egal\Core\Rest\Filter;

class ScopeCondition
{
    use Combinable;

    public const REG_PATTERN = "(?<scope>[a-zA-Z]+)\((?<parameters>[^)]*)\)";
    public const PARAMETER_REG_PATTERN = "/(?<key>\w+)\s*=\s*(?<value>[a-zA-Z0-9_+'-]+)/m";

    protected string $name;
    protected array $parameters;

    public static function make(string $name, array $parameters, Combiner $combiner = Combiner::And)
    {
        $condition = new static();
        $condition->name = $name;
        $condition->parameters = $parameters;
        $condition->combiner = $combiner;

        return $condition;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
