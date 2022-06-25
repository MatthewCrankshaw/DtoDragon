<?php

namespace DtoDragon\Test;

use DtoDragon\DataTransferObject;
use DtoDragon\Singletons\DtoServiceProviderSingleton;
use Mockery;

/**
 * @covers \DtoDragon\DataTransferObject
 */
class DataTransferObjectTest extends DtoDragonTestCase
{
    /**
     * @return void
     */
    public function testConstructEmptyDto(): void
    {
        $dto = $this->createTestDto();

        $mock = Mockery::mock(DtoServiceProviderSingleton::class);
        $mock->shouldReceive('getInstance')
            ->once()
            ->andReturnSelf();
        $mock->shouldReceive('boot')
            ->once();

        static::assertInstanceOf(DataTransferObject::class, $dto);
    }
}
