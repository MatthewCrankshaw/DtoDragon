<?php

namespace DtoDragon\Test\Utilities\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyDataNotProvidedException;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Test\TestDtos\ServiceDto;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Hydrator\DtoHydrator;

/**
 * @covers \DtoDragon\Utilities\Hydrator\DtoHydrator
 * @package DtoDragon\Test\Utilities\Hydrator
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

    /**
     * @covers /DtoDragon/Utilities/Hydrator/Dto
     */
    public function testHydratePropertyHydratorNotFound(): void
    {
        $this->expectException(PropertyDataNotProvidedException::class);
        $emptyDto = new MultiTypeDto();

        $dtoReflectorFactory = new DtoReflectorFactory($emptyDto);
        $dtoHydrator = new DtoHydrator($dtoReflectorFactory);
        $actual = $dtoHydrator->hydrate([
            'id' => 1,
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
}