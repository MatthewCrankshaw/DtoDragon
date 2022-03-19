<?php

namespace DtoDragon\Test\Utilities\Extractor;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\MultiTypeDto;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;

class ExtractorTest extends DtoDragonTestCase
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
        $dto = new MultiTypeDto($data);
        $factory = new DtoReflectorFactory($dto);
        $extractor = new DtoExtractor($factory);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }
}