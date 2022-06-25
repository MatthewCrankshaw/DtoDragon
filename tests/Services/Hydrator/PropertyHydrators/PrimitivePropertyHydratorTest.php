<?php

namespace DtoDragon\Test\Services\Hydrator\PropertyHydrators;

use DtoDragon\Services\Hydrator\PropertyHydrators\PrimitivePropertyHydrator;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Hydrator\PropertyHydrators\PrimitivePropertyHydrator
 */
class PrimitivePropertyHydratorTest extends DtoDragonTestCase
{
    public function testRegisteredType(): void
    {
        $hydrator = new PrimitivePropertyHydrator();
        static::assertSame('primitive', $hydrator->registeredType());
    }
}