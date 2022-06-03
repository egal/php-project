<?php

namespace Egal\Core\Rest\Scope;

use Illuminate\Support\Facades\Log;

class ScopeFunction
{
    public const REG_PATTERN = "/(?<scope>[a-zA-Z]+)\((?<parameters>[^)]*)\)/m";
    public const PARAMETER_REG_PATTERN = "/(?<key>\w+)\s*=\s*(?<value>[a-zA-Z0-9_+'-]+)/m";

    protected string $name;
    protected array $parameters;

    public static function make(string $name, array $parameters)
    {
        $scopeFunction = new static();
        $scopeFunction->name = $name;
        $scopeFunction->parameters = $parameters;

        return $scopeFunction;
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
