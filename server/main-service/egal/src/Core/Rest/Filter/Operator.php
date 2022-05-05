<?php

namespace Egal\Core\Rest\Filter;

use Egal\Core\Exceptions\FilterSqlOperatorNotFoundException;

enum Operator: string
{

    case Equals = 'eq';
    case NotEquals = 'not eq';
    case GreaterThenOperator = 'gt';
    case LessThenOperator = 'lt';
    case GreaterOrEqualOperator = 'ge';
    case LessOrEqualOperator = 'le';
    case ContainOperator = 'co';
    case StartWithOperator = 'sw';
    case EndWithOperator = 'ew';
    case NotContainOperator = 'not co';
    case EqualIgnoreCaseOperator = 'eqi';
    case ContainIgnoreCaseOperator = 'coi';
    case StartWithIgnoreCaseOperator = 'swi';
    case EndWithIgnoreCaseOperator = 'ewi';
    case NotEqualIgnoreCaseOperator = 'not eqi';
    case NotContainIgnoreCaseOperator = 'not coi';

    public function getSqlOperator(): string
    {
        switch ($this) {
            case self::Equals:
                return '=';
            case self::NotEquals:
                return '!=';
            case self::GreaterThenOperator:
                return '>';
            case self::LessThenOperator:
                return '<';
            case self::GreaterOrEqualOperator:
                return '>=';
            case self::LessOrEqualOperator:
                return '<=';
            case self::ContainOperator:
            case self::StartWithOperator:
            case self::EndWithOperator:
                return 'LIKE';
            case self::NotContainOperator:
                return 'NOT LIKE';
            case self::EqualIgnoreCaseOperator:
            case self::ContainIgnoreCaseOperator:
            case self::StartWithIgnoreCaseOperator:
            case self::EndWithIgnoreCaseOperator:
                return 'ILIKE';
            case self::NotEqualIgnoreCaseOperator:
            case self::NotContainIgnoreCaseOperator:
                return 'NOT ILIKE';
            default:
                throw new FilterSqlOperatorNotFoundException();
        }
    }

}
