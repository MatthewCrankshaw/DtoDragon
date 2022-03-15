<?php

namespace DtoDragon\Test\utilities;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\dtos\MultiTypeDto;
use DtoDragon\utilities\extractor\Extractor;

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
        $extractor = new Extractor($dto);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }
}