<?php

declare(strict_types=1);

namespace Egal\Core\Rest\Filter;


use Egal\Core\Exceptions\FilterParseException;

class Parser
{


    private string $conditionRegPattern;
    private string $subQueryRegPattern;
    private string $queryRegPattern;

    public function __construct()
    {
        $operatorsAsStrings = array_map(fn(Operator $operator) => $operator->value, Operator::cases());
        $combinersAsStrings = array_map(fn(Combiner $operator) => $operator->value, Combiner::cases());

        $operatorsPattern = implode('|', $operatorsAsStrings);
        $this->conditionRegPattern = "/^((?<combiner>and|or) )?(?<field>[a-z_]+) (?<operator>$operatorsPattern) (?<value>.+)$/";


        $combinersSimplePattern = implode('|', $combinersAsStrings);
        $this->subQueryRegPattern = "/^(?<combiner>$combinersSimplePattern) \((?<sub_query>.+)\)$/";

        $left = implode(' |', $combinersAsStrings);
        $right = implode('| ', $combinersAsStrings);
        $this->queryRegPattern = "/(?:^|$left ).+?(?= $right|$)/";
    }

    public function parse(?string $queryString, Combiner $combiner = Combiner::And): Query
    {
        $query = Query::make([], $combiner);

        if ($queryString === '' || $queryString === null) {
            return $query;
        }

        preg_match_all($this->queryRegPattern, $queryString, $queryMatches);
        $queryMatches = $queryMatches[0];

        for ($key = 0; $key < count($queryMatches); $key++) {
            if (substr_count($queryMatches[$key], '(') !== substr_count($queryMatches[$key], ')')) {
                $queryMatches[$key + 1] = $queryMatches[$key] . ' ' . $queryMatches[$key + 1];
                unset($queryMatches[$key]);
            }
        }

        foreach ($queryMatches as $match) {
            if (preg_match($this->conditionRegPattern, $match, $conditionMatches)) {
                $condition = $this->makeConditionFromRaw(
                    $conditionMatches['field'],
                    $conditionMatches['operator'],
                    $conditionMatches['value'],
                    $conditionMatches['combiner']
                );
                $query->addCondition($condition);
            } elseif (preg_match($this->subQueryRegPattern, $match, $subQueryStringMatches)) {
                $subQuery = $this->parse(
                    $subQueryStringMatches['sub_query'],
                    Combiner::from($subQueryStringMatches['combiner'])
                );
                $query->addCondition($subQuery);
            } else {
                throw new FilterParseException();
            }
        }

        return $query;
    }

    private function makeConditionFromRaw(string $field, string $operator, string $value, string $combiner): Condition
    {
        $operator = Operator::from($operator);

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
            throw new FilterParseException();
        }

        return $combiner === ''
            ? Condition::make($field, $operator, $value)
            : Condition::make($field, $operator, $value, Combiner::from($combiner));
    }

}
