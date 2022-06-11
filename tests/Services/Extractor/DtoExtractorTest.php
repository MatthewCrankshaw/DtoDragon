<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;

/**
 * @covers \DtoDragon\Services\Extractor\DtoExtractor
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
        $extractorFactory = new ExtractorFactory();
        $extractor = $extractorFactory($dto);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }

    public function testPropertyExtractorNotExist(): void
    {
        $dto = new MultiTypeDto([
            'id' => 10,
            'testString' => 'testing',
        ]);
        PropertyExtractorsSingleton::getInstance()->clear();
        $extractorFactory = new ExtractorFactory();
        $extractor = $extractorFactory($dto);

        $this->expectException(PropertyExtractorNotFoundException::class);
        $extractor->extract();
    }
}