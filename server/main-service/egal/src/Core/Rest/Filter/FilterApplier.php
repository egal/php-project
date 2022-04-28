<?php

namespace Egal\Core\Rest\Filter;

use Illuminate\Database\Eloquent\Builder;

class FilterApplier
{

    public static function applyQuery(Builder $query, Query $filterQuery): Builder
    {
        return $query->where(function($query) use ($filterQuery) {
            $filterConditions = $filterQuery->getConditions();

            foreach ($filterConditions as $condition) {
                self::applyCondition($query, $condition);
            }

            return $query;
        });
    }

    private static function applyCondition(Builder &$query, Query|Condition $condition)
    {
        if ($condition instanceof Query) {
            self::applyQuery($query, $condition);
        } else {
            $field = $condition->getField();
            $operator = $condition->getOperator()->value;
            $value = $condition->getValue();
            $combiner = $condition->getCombiner()->value;
//            self::validateConditionFieldAndValue($query, $field, $value);
//            $fieldName = $field->getName();

//            $relation = $field->getRelation();
            if (!empty($relation)) {
                $clause = static function ($query) use ($field, $operator, $value): void {
                    $query->where($field, $operator, $value);
                };
                $query->has($relation, '>=', 1, $combiner, $clause);
            } else {
                $query->where($field, $operator, $value, $combiner);
            }
        }
    }
//
//    private static function validateConditionFieldAndValue(Builder $query, Field $field, $value)
//    {
//    }

}
