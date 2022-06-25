<?php

namespace DtoDragon\Test\Services\Hydrator\PropertyHydrators;

use DtoDragon\Services\Hydrator\PropertyHydrators\AbstractPropertyHydrator;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionProperty;
use stdClass;

/**
 * @covers \DtoDragon\Services\Hydrator\PropertyHydrators\AbstractPropertyHydrator
 */
class AbstractPropertyHydratorTest extends DtoDragonTestCase
{
    public function provideHydrate(): array
    {
        $object = new stdClass();
        return [
            'null' => [
                null,
                null,
            ],
            'integer' => [
                1023213,
                1023213,
            ],
            'string' => [
                'string',
                'string',
            ],
            'float' => [
                1.2321,
                1.2321,
            ],
            'array' => [
                ['key' => 'value', 'test' => 12321],
                ['key' => 'value', 'test' => 12321],
            ],
            'object' => [
                $object,
                $object,
            ]
        ];
    }

    /**
     * @dataProvider provideHydrate
     */
    public function testHydrate($value, $expected): void
    {
        $property = $this->createMock(ReflectionProperty::class);
        $hydrator = new class extends AbstractPropertyHydrator {
            public function registeredType(): string
            {
                return 'does not matter';
            }
        };

        $actual = $hydrator->hydrate($property, $value);

        static::assertSame($expected, $actual);
    }
}