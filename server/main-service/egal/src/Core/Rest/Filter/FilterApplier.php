<?php

namespace Egal\Core\Rest\Filter;

use Egal\Core\Exceptions\FilterApplyException;
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

    private static function applyCondition(Builder $query, Query|Condition $condition)
    {
        if ($condition instanceof Query) {
            self::applyQuery($query, $condition);
        } else {
            $field = $condition->getField();
            $operator = $condition->getOperator();
            $sqlOperator = $operator->getSqlOperator();
            $value = $condition->getValue($operator);
            $combiner = $condition->getCombiner()->value;

            self::validateConditionFieldAndValue($query, $field, $value); #TODO передавать вместо query model metadata, перенести на уровень выше (проверять раньше)

            switch (true) {
                case $field instanceof MorphRelationField:
                    $relation = $field->getRelation();
                    $types = $field->getTypes();
                    $fieldName = $field->getField();

                    $clause = static function ($query) use ($fieldName, $sqlOperator, $value): void {
                        $query->where($fieldName, $sqlOperator, $value);
                    };

                    // TODO
                    // $clause = static fn() => $query->where($fieldName, $operator, $value);

                    $query->hasMorph($relation, $types, '>=', 1, $combiner, $clause);
                    break;
                case $field instanceof ExistsRelation: //TODO навзвать класс агрегатных функций и реализовать только exists, не делаем, нужно через филды делать
                    $relation = $field->getRelation();
                    $query->has($relation, $value ? '>=' : '<', 1, $combiner);
                    break;
                case $field instanceof RelationField:
                    $relation = $field->getRelation();
                    $fieldName = $field->getField();

                    $clause = static function ($query) use ($fieldName, $sqlOperator, $value): void {
                        $query->where($fieldName, $sqlOperator, $value);
                    };
                    $query->has($relation, '>=', 1, $combiner, $clause);
                    break;
                case $field instanceof Field:
                    $fieldName = $field->getName();

                    $query->where($fieldName, $sqlOperator, $value, $combiner);
                    break;
                default:
                    throw new FilterApplyException();
            }
        }
    }

    private static function validateConditionFieldAndValue(Builder $query, AbstractField $field, $value)
    {
    }

}
