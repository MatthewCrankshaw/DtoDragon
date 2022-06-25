<?php

namespace DtoDragon\Test\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Services\Hydrator\HydratorFactory;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Hydrator\DtoHydrator
 */
class DtoHydratorTest extends DtoDragonTestCase
{
    public function testHydrate(): void
    {
        $factory = new HydratorFactory();
        $hydrator = $factory();

        $actual = $hydrator->hydrate($this->createTestDto(), ['id' => 10, 'type' => 'example']);

        static::assertInstanceOf(DataTransferObject::class, $actual);
        static::assertSame(10, $actual->getId());
        static::assertSame('example', $actual->getType());
    }

    public function testHydrateNonNullableWithNull(): void
    {
        $dto = $this->createTestDto();
        $factory = new HydratorFactory();
        $hydrator = $factory();
        $data = [
            'id' => null,
            'type' => null,
        ];

        $this->expectException(NonNullablePropertyException::class);

        $hydrator->hydrate($dto, $data);
    }

    public function testHydrateIsNullableWithNull(): void
    {
        $expected = $this->createTestDto();
        $expected->setId(10)
            ->setType(null);

        $dto = $this->createTestDto();
        $factory = new HydratorFactory();
        $hydrator = $factory();
        $data = [
            'id' => 10,
            'type' => null,
        ];

        $actual = $hydrator->hydrate($dto, $data);

        static::assertEquals($expected, $actual);
    }

    public function testHydratePropertyHydratorNotFound(): void
    {
        $this->expectException(PropertyHydratorNotFoundException::class);
        $emptyDto = $this->createTestDto();
        $data = [
            'id' => 10,
            'type' => 'string'
        ];

        PropertyHydratorsSingleton::getInstance()->clear();

        $factory = new HydratorFactory();
        $hydrator = $factory();

        $hydrator->hydrate($emptyDto, $data);
    }

    public function testNullablePropertyHydrator(): void
    {
        $expected = $this->createTestDto();
        $expected->setId(1)
            ->setType('string');

        $data = [
            'id' => 1,
            'type' => 'string',
        ];

        $emptyDto = $this->createTestDto();

        $factory = new HydratorFactory();
        $hydrator = $factory();
        $actual = $hydrator->hydrate($emptyDto, $data);

        static::assertEquals($actual, $expected);
    }

    public function testUnsetPropertyHydrator(): void
    {
        $data = ['id' => 1];
        $expected = $this->createTestDto();
        $expected->setId(1);

        $emptyDto = $this->createTestDto();

        $factory = new HydratorFactory();
        $hydrator = $factory();
        $actual = $hydrator->hydrate($emptyDto, $data);

        static::assertEquals($actual, $expected);
    }
}