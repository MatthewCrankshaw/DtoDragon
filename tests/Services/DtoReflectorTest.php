<?php

namespace DtoDragon\Test\Services;

use DtoDragon\DataTransferObject;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\DtoReflector;

/**
 * @covers \DtoDragon\Services\DtoReflector
 */
class DtoReflectorTest extends DtoDragonTestCase
{
    public function testGetDto(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);

        $actual = $dtoReflector->getDto();

        static::assertSame($dto, $actual);
        static::assertInstanceOf(DataTransferObject::class, $actual);
    }

    public function testGetPropertiesIsArray(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        static::assertIsArray($properties);
    }

    public function testGetPropertiesCount(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        static::assertCount(2, $properties);
    }

    public function testGetPropertiesProtected(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        foreach ($properties as $property) {
            static::assertTrue($property->isProtected());
        }
    }

    public function testGetPropertyValue(): void
    {
        $dto = $this->createTestDto();
        $dto->setId(1);

        $reflector = new DtoReflector($dto);
        $properties = $reflector->getProperties();
        $id = $reflector->getPropertyValue($properties[0]);

        static::assertSame(1, $id);
    }

    public function testSetPropertyValue(): void
    {
        $dto = $this->createTestDto();
        $reflector = new DtoReflector($dto);

        $properties = $reflector->getProperties();
        $reflector->setPropertyValue($properties[0], 10);
        $id = $reflector->getPropertyValue($properties[0]);

        static::assertSame(10, $id);
    }

    public function testPropertyIsNullable() {
        $dto = $this->createTestDto();

        $reflector = new DtoReflector($dto);
        $idProperty = $reflector->getProperties()[0];
        $typeProperty = $reflector->getProperties()[1];
        $idActual = $reflector->propertyIsNullable($idProperty);
        $typeActual = $reflector->propertyIsNullable($typeProperty);

        static::assertSame(false, $idActual);
        static::assertSame(true, $typeActual);
    }
}