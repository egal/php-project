<?php

namespace Egal\Tests\Core\Rest\Select;

use Egal\Core\Rest\Select\Parser;
use PHPUnit\Framework\TestCase;

class SelectQueryStringParserTest extends TestCase
{
/**
     * @dataProvider fieldDataProvider
     * @dataProvider relationFieldDataProvider
     * @dataProvider morphRelationFieldDataProvider
     */
    public function testParsingStringQueryToArray(?string $stringQuery, array $expected): void
    {
        if (is_string($expected)) {
            $this->expectException($expected);
        }

        $this->assertEquals($expected, (new Parser())->parse($stringQuery));
    }

    public function fieldDataProvider()
    {
        return;
    }

    public function relationFieldDataProvider()
    {
        return;
    }

    public function morphRelationFieldDataProvider()
    {
        return;
    }
}
