<?php

namespace Egal\Core\Rest\Select;

use Egal\Core\Rest\Filter\Field;
use Egal\Core\Rest\Filter\RelationField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class Applier
{
    public static function apply(Builder $query, array $fieldObjects): Builder
    {
        if ($fieldObjects === []) {
            throw new \Exception('Select fields not specified!', 400);
        }

        $selectRelationFields = [];
        $selectFields = [];
        foreach ($fieldObjects as $fieldObject) {
            if($fieldObject instanceof RelationField) {
                $relation = $fieldObject->getRelation();
                $fieldName = $fieldObject->getField();
                $selectRelationFields[$relation][] = $fieldName;
            } elseif ($fieldObject instanceof Field) {
                $selectFields[] = $fieldObject->getName();
            }
        }

        $query->select($selectFields);

        foreach ($selectRelationFields as $relation => $fields) {
            $query->with($relation . ':' . implode(',', $fields));
        }

        return $query;
    }
}
