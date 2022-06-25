<?php

namespace DtoDragon\Test\Services\Hydrator;

use DtoDragon\Services\Hydrator\DtoHydrator;
use DtoDragon\Services\Hydrator\HydratorFactory;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Hydrator\HydratorFactory
 */
class HydratorFactoryTest extends DtoDragonTestCase
{
    public function testInvoke(): void
    {
        $factory = new HydratorFactory();
        $hydrator = $factory();

        static::assertInstanceOf(DtoHydrator::class, $hydrator);
    }
}