<?php

namespace DtoDragon\Test\Utilities;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\ServiceDto;
use DtoDragon\Utilities\DtoReflector;
use DtoDragon\Utilities\DtoReflectorFactory;

/**
 * @covers \DtoDragon\Utilities\DtoReflectorFactory
 * @package DtoDragon\Test\DtoDragonTestCase
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