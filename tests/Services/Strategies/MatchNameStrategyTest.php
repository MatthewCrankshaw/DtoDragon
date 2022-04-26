<?php

namespace DtoDragon\Test\Services\Strategies;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\Strategies\MatchNameStrategy;

/**
 * @covers \DtoDragon\Services\Strategies\MatchNameStrategy
 */
class MatchNameStrategyTest extends DtoDragonTestCase
{
    public function provideData(): array
    {
        return [
            'simple field name' => [
                'name',
                'name',
            ],
            'field name with underscore' => [
                '_private',
                '_private'
            ],
            'camel cased field name' => [
                'camelCasedFieldName',
                'camelCasedFieldName',
            ],
            'snake cased field name' => [
                'snake_case',
                'snake_case',
            ],
        ];
    }

    /**
     * @dataProvider provideData
     *
     * @param string $field
     * @param string $expected
     *
     * @return void
     */
    public function testFieldToArrayKey(string $field, string $expected): void
    {
        $strategy = new MatchNameStrategy();

        $actual = $strategy->fieldToArrayKey($field);

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider provideData
     *
     * @param string $field
     * @param string $expected
     *
     * @return void
     */
    public function testArrayKeyToField(string $field, string $expected): void
    {
        $strategy = new MatchNameStrategy();

        $actual = $strategy->arrayKeyToField($field);

        $this->assertSame($expected, $actual);
    }
}