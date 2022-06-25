<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Services\Extractor\DtoExtractor
 */
class DtoExtractorTest extends DtoDragonTestCase
{
    public function testExtract(): void
    {
        $dto = $this->createTestDto();
        $dto->setId(10)
            ->setType('example');

        $extractorFactory = new ExtractorFactory();
        $extractor = $extractorFactory();

        $actual = $extractor->extract($dto);

        static::assertIsArray($actual);
    }

    public function testPropertyExtractorNotExist(): void
    {
        $dto = $this->createTestDto();
        $dto->setId(10)
            ->setType('testing');

        PropertyExtractorsSingleton::getInstance()->clear();
        $extractorFactory = new ExtractorFactory();
        $extractor = $extractorFactory();

        $this->expectException(PropertyExtractorNotFoundException::class);
        $extractor->extract($dto);
    }
}