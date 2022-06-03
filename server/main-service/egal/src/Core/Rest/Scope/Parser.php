<?php

namespace Egal\Core\Rest\Scope;

use Egal\Core\Exceptions\ScopeParseException;
use Illuminate\Support\Facades\Log;

class Parser
{

    public function parse(?string $queryString): array
    {
        $scopes = [];

        if ($queryString === '' || $queryString === null) {
            return $scopes;
        }

        preg_match_all(ScopeFunction::REG_PATTERN, $queryString, $scopesRaw,PREG_SET_ORDER, 0);

        foreach ($scopesRaw as $scope) {
            $parameters = [];

            if (array_key_exists('parameter', $scope)) {
                preg_match_all(ScopeFunction::PARAMETER_REG_PATTERN, $scope['parameter'], $matches, PREG_SET_ORDER, 0);

                foreach($matches as $parameter) {
                    if (array_key_exists('key', $parameter) && array_key_exists('value', $parameter)) {
                        $parameters[] = [
                            'key' => $parameter['key'],
                            'value' => $this->makeValueFromRaw($parameter['value'])
                        ];
                    } else {
                        throw new ScopeParseException();
                    }
                }
            }
            $scopes[] = ScopeFunction::make($scope['scope'], $parameters);
        }

        return $scopes;
    }

    private function makeValueFromRaw(string $value): string|int|bool|null|float
    {
        if ($value === 'true') {
            $value = true;
        } elseif ($value === 'false') {
            $value = false;
        } elseif ($value === 'null') {
            $value = null;
        } elseif (preg_match("/^'.+'$/", $value)) { // string type
            $value = ltrim(rtrim($value, "'"), "'");
        } elseif (preg_match("/^[1-9]+$/", $value)) { // int type
            $value = intval($value);
        } elseif (preg_match("/^[1-9]+\.[1-9]+$/", $value)) { // float type
            $value = floatval($value);
        } else {
            throw new ScopeParseException();
        }
        return $value;
    }
}
