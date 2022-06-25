<?php

namespace DtoDragon\Test\Services\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionProperty;

/**
 * @covers \DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor
 */
class DtoPropertyExtractorTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new DtoPropertyExtractor($extractor);

        static::assertInstanceOf(DtoPropertyExtractor::class, $propertyExtractor);
    }

    public function testRegisterType(): void
    {
        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new DtoPropertyExtractor($extractor);

        $actual = $propertyExtractor->registeredType();

        static::assertSame(DataTransferObject::class, $actual);
    }

    public function testExtractWhenNull(): void
    {
        $dto = $this->createMock(DataTransferObject::class);

        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getValue')
            ->with($dto)
            ->willReturn(null);

        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new DtoPropertyExtractor($extractor);

        $actual = $propertyExtractor->extract($dto, $property);

        static::assertNull($actual);
    }

    public function testExtract(): void
    {
        $expected = [
            'id' => 10,
            'type' => 'type',
        ];
        $dto = $this->createMock(DataTransferObject::class);
        $nestedDto = $this->createTestDto()->setId(10)->setType('type');

        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getValue')
            ->with($dto)
            ->willReturn($nestedDto);

        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new DtoPropertyExtractor($extractor);

        $actual = $propertyExtractor->extract($dto, $property);

        static::assertSame($expected, $actual);
    }
}