<?php

namespace DtoDragon\Test\utilities;

use DtoDragon\DataTransferObject;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\dtos\MultiTypeDto;
use DtoDragon\utilities\DtoReflectorFactory;
use DtoDragon\utilities\hydrator\Hydrator;

class HydratorTest extends DtoDragonTestCase
{
    public function provideHydrate():array
    {
        return [
            'flat hydrate' => [
                [
                    'id' => 10,
                    'testString' => 'this is a string'
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
        $factory = new DtoReflectorFactory();
        $hydrator = new Hydrator($dto, $factory);

        $actual = $hydrator->hydrate($data);

        $this->assertInstanceOf(DataTransferObject::class, $actual);
    }
}