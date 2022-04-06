<?php

namespace Egal\Tests\Core\Rest\Filter;

use Egal\Core\Exceptions\RequestFilterQueryStringParseException;
use Egal\Core\Http\RequestFilterQueryParser;
use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\CompositeCondition;
use Egal\Core\Rest\Filter\Condition;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query;
use PHPUnit\Framework\TestCase;

class RequestFilterQueryStringParserTest extends TestCase
{
    public function parseFilterQueryDataProvider(): array
    {

        return [
            [
                'field1 eq value1',
                new Query([
                    new Condition('filed1', Operator::Equal, 'value1',Combiner::And)
                ]),
                null,
            ],
            [
                '(field1 eq value1 and (field2 eq value2 or field3 eq value3)) or field4 equal value4',
                new Query([
                    new CompositeCondition([
                        new Condition('field1', Operator::Equal, 'value1', Combiner::And),
                        new CompositeCondition([
                            new Condition('field2', Operator::Equal, 'value2', Combiner::And),
                            new Condition( 'field3', Operator::Equal, 'value3', Combiner::Or),
                        ], Combiner::And),
                        new Condition('field4', Operator::Equal, 'value4', Combiner::Or),
                    ], Combiner::And),
                ]),
                null,
            ],
            [
                'field1 eq',
                null,
                RequestFilterQueryStringParseException::class,
            ],
            [
                'field1 eq value1 field2 eq value2',
                null,
                RequestFilterQueryStringParseException::class,
            ],
            [
                'field1 eq value1 or field2 eq value2',
                new Query([
                    new Condition('field1', Operator::Equal, 'value1', Combiner::And),
                    new Condition('field2', Operator::Equal, 'value2', Combiner::Or),
                ]),
                null,
            ],
            [
                'field1 eq   value1 or field2 eq value2',
                null,
                RequestFilterQueryStringParseException::class,
            ],
            [
                'field1 gt value1 and (field2 eq value2 or field3 eq value3)',
                new Query([
                    new Condition('field1', Operator::GreaterThen, 'value1', Combiner::And),
                    new CompositeCondition([
                        new Condition('field2', Operator::Equal, 'value2', Combiner::And),
                        new Condition('field3', Operator::Equal, 'value3', Combiner::Or),
                    ], Combiner::And),
                ]),
                null,
            ],
            [
                'field1 gt value1 AND field2 eq value2',
                null,
                RequestFilterQueryStringParseException::class,
            ]
        ];
    }

    /**
     * @dataProvider parseFilterQueryDataProvider()
     */
    public function testParseFilterQuery(string $filterQueryString, Query $exceptFilterQuery, ?string $expectException)
    {
        if ($expectException) {
            $this->expectException($expectException);
        }

        $resultFilterQuery = RequestFilterQueryParser::parseFilters($filterQueryString);
        $this->assertEquals($resultFilterQuery, $exceptFilterQuery);
    }
}
