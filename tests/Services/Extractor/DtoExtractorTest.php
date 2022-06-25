<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Services\Extractor\DtoExtractor;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Services\Extractor\PropertyOmitter;
use DtoDragon\Services\Strategies\MatchNameStrategy;
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
        static::assertSame(['id' => 10, 'type' => 'example'], $actual);
    }

    public function testExtractOmittedProperties(): void
    {
        $dto = $this->createTestDto();
        $dto->setId(10)
            ->setType('example');

        $namingStrategy = new MatchNameStrategy();
        $omitter = $this->createMock(PropertyOmitter::class);
        $omitter->expects(static::exactly(2))
            ->method('omitted')
            ->willReturn(['id']);

        $extractor = new DtoExtractor($namingStrategy, $omitter);
        $actual = $extractor->extract($dto);

        static::assertIsArray($actual);
        static::assertSame(['type' => 'example'], $actual);
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