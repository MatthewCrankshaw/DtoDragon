<?php

namespace DtoDragon\Test\Utilities;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\ServiceDto;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\DtoReflectorFactory;

/**
 * @covers \DtoDragon\Services\DtoReflectorFactory
 */
class DtoReflectorFactoryTest extends DtoDragonTestCase
{
    public function testCreate(): void
    {
        $dto = new ServiceDto([
            'id' => 1,
            'type' => 'service',
            'price' => null,
        ]);
        $factory = new DtoReflectorFactory($dto);
        $actual = $factory->create();

        $this->assertInstanceOf(DtoReflector::class, $actual);
    }
}