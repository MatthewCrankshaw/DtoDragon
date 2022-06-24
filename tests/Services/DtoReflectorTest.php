<?php

namespace DtoDragon\Test\Services;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\DtoReflector;

/**
 * @covers \DtoDragon\Services\DtoReflector
 */
class DtoReflectorTest extends DtoDragonTestCase
{
    public function testGetPropertiesIsArray(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertIsArray($properties);
    }

    public function testGetPropertiesCount(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertCount(2, $properties);
    }

    public function testGetPropertiesProtected(): void
    {
        $dto = $this->createTestDto();
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        foreach ($properties as $property) {
            $this->assertTrue($property->isProtected());
        }
    }

    public function testGetPropertyValue(): void
    {
        $dto = $this->createTestDto();
        $dto->setId(1);

        $reflector = new DtoReflector($dto);
        $properties = $reflector->getProperties();
        $id = $reflector->getPropertyValue($properties[0]);

        $this->assertSame(1, $id);
    }

    public function testSetPropertyValue(): void
    {
        $dto = $this->createTestDto();
        $reflector = new DtoReflector($dto);

        $properties = $reflector->getProperties();
        $reflector->setPropertyValue($properties[0], 10);
        $id = $reflector->getPropertyValue($properties[0]);

        $this->assertSame(10, $id);
    }

    public function testPropertyIsNullable() {
        $dto = $this->createTestDto();

        $reflector = new DtoReflector($dto);
        $idProperty = $reflector->getProperties()[0];
        $typeProperty = $reflector->getProperties()[1];
        $idActual = $reflector->propertyIsNullable($idProperty);
        $typeActual = $reflector->propertyIsNullable($typeProperty);

        $this->assertSame(false, $idActual);
        $this->assertSame(true, $typeActual);
    }
}