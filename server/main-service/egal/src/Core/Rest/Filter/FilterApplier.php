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
            $operator = $condition->getOperator()->getSqlOperator();
            $value = $condition->getValue();
            $combiner = $condition->getCombiner()->value;
            self::validateConditionFieldAndValue($query, $field, $value);
            $fieldName = $field->getName();

            if ($field instanceof RelationField) {
                $relation = $field->getRelation();
                $clause = static function ($query) use ($combiner, $fieldName, $operator, $value): void {
                    $query->where($fieldName, $operator, $value, $combiner);
                };
                $query->has($relation, '>=', 1, $combiner, $clause);
            } else {
                $query->where($fieldName, $operator, $value, $combiner);
            }
        }
    }

    private static function validateConditionFieldAndValue(Builder $query, Field|RelationField $field, $value)
    {
    }

}
