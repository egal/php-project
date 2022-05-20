<?php

declare(strict_types=1);

namespace Egal\Core\Rest\Filter;


use Egal\Core\Exceptions\FilterParseException;

class Parser
{
    protected const FIELD_PATTERN = '[a-z_]+';
    protected const RELATION_FIELD_PATTERN = "(?<relation>[a-z_]+)\.{1}(?<relation_field>[a-z_]+)";
    protected const MORPH_RELATION_FIELD_PATTERN = "(?<morph_relation>[a-z_]+)\[(?<types>([a-z_,]+))\]\.(?<morph_relation_field>[a-z_]+)";
    protected const EXISTS_RELATION_PATTERN = "(?<exists_relation>[a-z_]+)\.(exists)\(\)";

    private string $conditionRegPattern;
    private string $subQueryRegPattern;
    private string $queryRegPattern;

    public function __construct()
    {
        $operatorsAsStrings = array_map(fn(Operator $operator) => $operator->value, Operator::cases());
        $combinersAsStrings = array_map(fn(Combiner $operator) => $operator->value, Combiner::cases());

        $operatorsPattern = implode('|', $operatorsAsStrings);
        $fieldElementPattern = "((?<field_element>" . self::FIELD_PATTERN . ")|(?<relation_field_element>" . self::RELATION_FIELD_PATTERN . ")|(?<morph_relation_field_element>" . self::MORPH_RELATION_FIELD_PATTERN . ")|(?<exists_relation_element>" . self::EXISTS_RELATION_PATTERN . "))";
        $this->conditionRegPattern = "/^((?<combiner>and|or) )?$fieldElementPattern (?<operator>$operatorsPattern) (?<value>.+)$/";


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
                $notEmptyFieldElementArray = array_filter([
                    $conditionMatches['field_element'],
                    $conditionMatches['relation_field_element'],
                    $conditionMatches['morph_relation_field_element'],
                    $conditionMatches['exists_relation_element']
                ]);
                $condition = $this->makeConditionFromRaw(
                    array_shift($notEmptyFieldElementArray),
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

        $value = $this->makeValueFromRaw($value);

        $field = $this->makeFieldFromRaw($field);

        return $combiner === ''
            ? Condition::make($field, $operator, $value)
            : Condition::make($field, $operator, $value, Combiner::from($combiner));
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
            throw new FilterParseException();
        }
        return $value;
    }

    private function makeFieldFromRaw(string $field): AbstractField
    {
        switch (true) {
            case preg_match("/^" . self::MORPH_RELATION_FIELD_PATTERN . "$/", $field, $matches):
                $field = new MorphRelationField($matches['morph_relation_field'], $matches['morph_relation'], $matches['types']);
                break;
            case preg_match("/^" . self::EXISTS_RELATION_PATTERN . "$/", $field, $matches):
                $field = new ExistsRelation($matches['exists_relation']);
                break;
            case preg_match("/^" . self::RELATION_FIELD_PATTERN . "$/", $field, $matches):
                $field = new RelationField($matches['relation_field'], $matches['relation']);
                break;
            case preg_match("/^" . self::FIELD_PATTERN . "$/", $field):
                $field = new Field($field);
                break;
            default:
                throw new FilterParseException();
        }

        return $field;
    }

}
