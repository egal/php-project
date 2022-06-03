<?php

namespace Egal\Core\Rest\Scope;

use Illuminate\Support\Facades\Log;

class Applier
{

    public static function apply(\Illuminate\Database\Eloquent\Builder $query, array $scopeObjects)
    {
        $scopes = [];
        Log::debug('scopeApplier', $scopeObjects);
        foreach ($scopeObjects as $scopeObject) {
            $scope = $scopeObject->getName();
            $parameters = $scopeObject->getParameters();
            $scopes[$scope] = $parameters;
            $query->scopes($scopes);
        }
        return $query;
    }
}
