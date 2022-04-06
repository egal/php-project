<?php

namespace Egal\Core\Http;

use Egal\Core\Exceptions\RequestFilterQueryStringParseException;
use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\CompositeCondition;
use Egal\Core\Rest\Filter\Condition;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query as FilterQuery;

class RequestFilterQueryParser
{
    const QUERY_REGEX = '';
    const CONDITION_REGEX = '';
    const COMPOSITE_CONDITION_REGEX = '';

    protected FilterQuery $filters;

    public static function parseFilters(string $queryString): FilterQuery
    {
        $filterQuery = new FilterQuery();

        if (preg_match(self::QUERY_REGEX, $queryString, $queryContents)) {
            foreach ($queryContents as $queryContent) {
                $condition = self::parseCondition($queryContent);
                $filterQuery->addContentItem($condition);
            }
        }

        return $filterQuery;
    }

    public static function parseCondition(mixed $conditionString): mixed
    {
        switch ($conditionString) {
            case (bool)preg_match(self::COMPOSITE_CONDITION_REGEX, $conditionString, $compositeConditionContents) :
                return self::getCompositeCondition($compositeConditionContents);
            case (bool)preg_match(self::CONDITION_REGEX, $conditionString, $conditionContents) :
                return self::getCondition($conditionContents);
            default :
                throw new RequestFilterQueryStringParseException();
        }
    }

    public static function getCompositeCondition(array $compositeConditionContents): CompositeCondition
    {
        $combiner = Combiner::tryFrom(array_shift($compositeConditionContents)) ?? Combiner::And;
        $conditions = [];
        foreach ($compositeConditionContents as $compositeConditionContent) {
            $condition = self::parseCondition($compositeConditionContent);
            $conditions[] = $condition;
        }
        return new CompositeCondition($conditions, $combiner);
    }

    private static function getCondition(array $conditionContents): Condition
    {
        $combiner = Combiner::tryFrom(array_shift($conditionContents)) ?? Combiner::And;
        $operator = Operator::from($conditionContents[1]);
        return new Condition($conditionContents[0], $operator, $conditionContents[2], $combiner);
    }

}
