<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Services\Extractor\PropertyOmitter;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Extractor\PropertyOmitter
 */
class PropertyOmitterTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $omitter = new PropertyOmitter();
        $properties = $this->getProtectedProperty($omitter, 'properties');

        static::assertInstanceOf(PropertyOmitter::class, $omitter);
        static::assertEmpty($properties);
        static::assertIsArray($properties);
    }

    public function testAdd(): void
    {
        $expected = [
            'a',
            '',
            '!@#$',
            'veryLongPropertyName',
            'under_scored'
        ];
        $omitter = new PropertyOmitter();
        $omitter->add('a');
        $omitter->add('');
        $omitter->add('!@#$');
        $omitter->add('veryLongPropertyName');
        $omitter->add('under_scored');

        $properties = $this->getProtectedProperty($omitter, 'properties');
        static::assertSame($expected, $properties);
        static::assertCount(5, $properties);
    }

    public function testOmitted(): void
    {
        $expected = [
            'a',
            '',
            '!@#$',
            'veryLongPropertyName',
            'under_scored'
        ];
        $omitter = new PropertyOmitter();
        $this->setReflectionPropertyValue($omitter, 'properties', $expected);

        $properties = $omitter->omitted();
        static::assertSame($expected, $properties);
        static::assertCount(5, $properties);
    }
}