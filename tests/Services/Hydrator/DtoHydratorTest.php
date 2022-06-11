<?php

namespace DtoDragon\Test\Services\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Services\Hydrator\HydratorFactory;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Test\TestDtos\ServiceDto;

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
        $factory = new HydratorFactory();
        $hydrator = $factory($dto);

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

        $factory = new HydratorFactory();
        $hydrator = $factory($emptyDto);
        $actual = $hydrator->hydrate([
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

        $factory = new HydratorFactory();
        $hydrator = $factory($emptyDto);
        $actual = $hydrator->hydrate([
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

        $factory = new HydratorFactory();
        $hydrator = $factory($emptyDto);
        $actual = $hydrator->hydrate([
            'type' => 'string',
            'price' => null
        ]);

        $this->assertEquals($actual, $expected);
    }
}