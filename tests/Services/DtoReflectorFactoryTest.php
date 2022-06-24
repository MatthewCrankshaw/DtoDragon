<?php

namespace DtoDragon\Test\Services;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\DtoReflector;
use DtoDragon\Services\DtoReflectorFactory;

/**
 * @covers \DtoDragon\Services\DtoReflectorFactory
 */
class DtoReflectorFactoryTest extends DtoDragonTestCase
{
    public function testInvoke(): void
    {
        $dto = $this->createTestDto();
        $factory = new DtoReflectorFactory();
        $actual = $factory($dto);

        $this->assertInstanceOf(DtoReflector::class, $actual);
    }
}