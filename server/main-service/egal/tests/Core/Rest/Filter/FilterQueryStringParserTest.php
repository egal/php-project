<?php

namespace Egal\Tests\Core\Rest\Filter;

use Egal\Core\Exceptions\FilterParseException;
use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\Condition;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Parser;
use Egal\Core\Rest\Filter\Query;
use PHPUnit\Framework\TestCase;

class FilterQueryStringParserTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                null,
                Query::make([], Combiner::And),
            ],
            [
                "",
                Query::make([], Combiner::And),
            ],
            [
                " ",
                FilterParseException::class,
            ],
            [
                "a",
                FilterParseException::class,
            ],
            [
                "field eq",
                FilterParseException::class,
            ],
            [
                "eq value",
                FilterParseException::class,
            ],
            [
                "eq",
                FilterParseException::class,
            ],
            [
                "field eq value",
                FilterParseException::class,
            ],
            [
                "field eq true",
                Query::make([
                    Condition::make('field', Operator::Equals, true, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field not eq true",
                Query::make([
                    Condition::make('field', Operator::NotEquals, true, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field eq false",
                Query::make([
                    Condition::make('field', Operator::Equals, false, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field eq null",
                Query::make([
                    Condition::make('field', Operator::Equals, null, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field eq 1",
                Query::make([
                    Condition::make('field', Operator::Equals, 1, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field eq 1.5",
                Query::make([
                    Condition::make('field', Operator::Equals, 1.5, Combiner::And),
                ], Combiner::And),
            ],
            [
                "field eq 'string'",
                Query::make([
                    Condition::make('field', Operator::Equals, 'string', Combiner::And),
                ], Combiner::And),
            ],
            [
                "first eq 1 and second eq 2",
                Query::make([
                    Condition::make('first', Operator::Equals, 1, Combiner::And),
                    Condition::make('second', Operator::Equals, 2, Combiner::And),
                ], Combiner::And),
            ],
            [
                "first eq 1 and second eq 2 or third eq 3",
                Query::make([
                    Condition::make('first', Operator::Equals, 1, Combiner::And),
                    Condition::make('second', Operator::Equals, 2, Combiner::And),
                    Condition::make('third', Operator::Equals, 3, Combiner::Or),
                ], Combiner::And),
            ],
            [
                "first eq 1 and second eq 2 and third eq 3 and (fourth eq 4 or fifth eq 5) and sixth eq 6",
                Query::make([
                    Condition::make('first', Operator::Equals, 1, Combiner::And),
                    Condition::make('second', Operator::Equals, 2, Combiner::And),
                    Condition::make('third', Operator::Equals, 3, Combiner::And),
                    Query::make([
                        Condition::make('fourth', Operator::Equals, 4, Combiner::And),
                        Condition::make('fifth', Operator::Equals, 5, Combiner::Or),
                    ], Combiner::And),
                    Condition::make('sixth', Operator::Equals, 6, Combiner::And),
                ], Combiner::And),
            ],
            [
                "first eq 1 and second eq 2 and third eq 3 and (fourth eq 4 or (fifth eq 5 or sixth eq 6))",
                Query::make([
                    Condition::make('first', Operator::Equals, 1, Combiner::And),
                    Condition::make('second', Operator::Equals, 2, Combiner::And),
                    Condition::make('third', Operator::Equals, 3, Combiner::And),
                    Query::make([
                        Condition::make('fourth', Operator::Equals, 4, Combiner::And),
                        Query::make([
                            Condition::make('fifth', Operator::Equals, 5, Combiner::And),
                            Condition::make('sixth', Operator::Equals, 6, Combiner::Or),
                        ], Combiner::Or),
                    ], Combiner::And),
                ], Combiner::And),
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testParsingStringQueryToArrayQuery(?string $stringQuery, Query|string $expected): void
    {
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        $this->assertEquals($expected, (new Parser())->parse($stringQuery));
    }
}
