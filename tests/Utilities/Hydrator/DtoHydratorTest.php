<?php

namespace DtoDragon\Test\Utilities\Hydrator;

use DtoDragon\DataTransferObject;
use DtoDragon\Exceptions\NonNullablePropertyException;
use DtoDragon\Exceptions\PropertyDataNotProvidedException;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\MultiTypeDto;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Hydrator\DtoHydrator;

class DtoHydratorTest extends DtoDragonTestCase
{
    public function provideHydrate():array
    {
        return [
            'flat hydrate' => [
                [
                    'id' => 10,
                    'testString' => 'this is a string',
                    'date' => '12-10-2012',
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
            'date' => '15-05-2020'
        ]);
    }

    public function testHydratePropertyHydratorNotFound(): void
    {
        $this->expectException(PropertyDataNotProvidedException::class);
        $dto = new MultiTypeDto([
            'id' => 1,
            'date' => '15-05-2020'
        ]);
    }
}