<?php

namespace DtoDragon\Test\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Test\TestDtos\ServiceDto;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Hydrator\DtoHydrator;

/**
 * @covers \DtoDragon\Services\Hydrator\DtoHydrator
 */
class DtoHydratorTest extends DtoDragonTestCase
{
    public function provideHydrate():array
    {
        return [
            'flat hydrate' => [
                [
                    'id' => 10,
                    'testString' => 'this is a string',
                ]
            ],
        ];
    }

    /**
     * @dataProvider provideHydrate
     */
    public function testHydrate(array $data): void
    {
        $dto = new MultiTypeDto();
        $factory = new DtoReflectorFactory($dto);
        $hydrator = new DtoHydrator($factory);

        $actual = $hydrator->hydrate($data);

        $this->assertInstanceOf(DataTransferObject::class, $actual);
    }

    public function testHydrateNonNullableWithNull(): void
    {
        $this->expectException(NonNullablePropertyException::class);
        $dto = new MultiTypeDto([
            'id' => null,
            'testString' => 'string',
        ]);
    }

    public function testHydratePropertyHydratorNotFound(): void
    {
        $this->expectException(PropertyHydratorNotFoundException::class);
        $emptyDto = new MultiTypeDto();

        PropertyHydratorsSingleton::getInstance()->clear();

        $dtoReflectorFactory = new DtoReflectorFactory($emptyDto);
        $dtoHydrator = new DtoHydrator($dtoReflectorFactory);
        $actual = $dtoHydrator->hydrate([
            'id' => 1,
            'testString' => 'string',
        ]);
    }

    public function testNullablePropertyHydrator(): void
    {
        $expected = new ServiceDto([
            'id' => 1,
            'type' => 'string',
            'price' => null
        ]);
        $emptyDto = new ServiceDto();

        $dtoReflectorFactory = new DtoReflectorFactory($emptyDto);
        $dtoHydrator = new DtoHydrator($dtoReflectorFactory);
        $actual = $dtoHydrator->hydrate([
            'id' => 1,
            'type' => 'string',
            'price' => null
        ]);

        $this->assertEquals($actual, $expected);
    }

    /**
     * You should be able to hydrate a dto partially through the constructor
     * if the property is not filled it will be left unset
     *
     * @return void
     */
    public function testUnsetPropertyHydrator(): void
    {
        $expected = new ServiceDto([
            'type' => 'string',
            'price' => null
        ]);
        $emptyDto = new ServiceDto();

        $dtoReflectorFactory = new DtoReflectorFactory($emptyDto);
        $dtoHydrator = new DtoHydrator($dtoReflectorFactory);
        $actual = $dtoHydrator->hydrate([
            'type' => 'string',
            'price' => null
        ]);

        $this->assertEquals($actual, $expected);
    }
}