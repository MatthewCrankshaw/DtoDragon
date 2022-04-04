<?php

namespace DtoDragon\Test\Utilities\Extractor;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\MultiTypeDto;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;

/**
 * @covers \DtoDragon\Utilities\Extractor\DtoExtractor
 * @package DtoDragon\Test\Utilities\Extractor
 */
class DtoExtractorTest extends DtoDragonTestCase
{
    public function provideExtract():array
    {
        return [
            'flat extract' => [
                [
                    'id' => 10,
                    'testString' => 'this is a string',
                    'date' => '12-05-2012',
                ]
            ],
        ];
    }

    /**
     * @dataProvider provideExtract
     */
    public function testExtract(array $data): void
    {
        $dto = new MultiTypeDto($data);
        $factory = new DtoReflectorFactory($dto);
        $extractor = new DtoExtractor($factory);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }
}