<?php

namespace Egal\Core\Rest\Filter;

use Egal\Core\Exceptions\FilterSqlOperatorNotFoundException;

enum Operator: string
{

    case Equals = 'eq';
    case NotEquals = 'not eq';


    public function getSqlOperator(): string
    {
        switch ($this) {
            case self::Equals:
                return '=';
            case self::NotEquals:
                return '!=';
//            case self::GREATER_THEN_OPERATOR:
//                return '>';
//            case self::LESS_THEN_OPERATOR:
//                return '<';
//            case self::GREATER_OR_EQUAL_OPERATOR:
//                return '>=';
//            case self::LESS_OR_EQUAL_OPERATOR:
//                return '<=';
//            case self::CONTAIN_OPERATOR:
//            case self::START_WITH_OPERATOR:
//            case self::END_WITH_OPERATOR:
//                return 'LIKE';
//            case self::NOT_CONTAIN_OPERATOR:
//                return 'NOT LIKE';
//            case self::EQUAL_IGNORE_CASE_OPERATOR:
//            case self::CONTAIN_IGNORE_CASE_OPERATOR:
//            case self::START_WITH_IGNORE_CASE_OPERATOR:
//            case self::END_WITH_IGNORE_CASE_OPERATOR:
//                return 'ILIKE';
//            case self::NOT_EQUAL_IGNORE_CASE_OPERATOR:
//            case self::NOT_CONTAIN_IGNORE_CASE_OPERATOR:
//                return 'NOT ILIKE';
            default:
                throw new FilterSqlOperatorNotFoundException();
        }
    }

}
