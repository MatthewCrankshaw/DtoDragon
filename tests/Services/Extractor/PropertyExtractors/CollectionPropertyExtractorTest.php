<?php

namespace DtoDragon\Test\Services\Extractor\PropertyExtractors;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Services\Extractor\ExtractorFactory;
use DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionProperty;

/**
 * @covers \DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor
 */
class CollectionPropertyExtractorTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new CollectionPropertyExtractor($extractor);

        static::assertInstanceOf(CollectionPropertyExtractor::class, $propertyExtractor);
    }

    public function testRegisterType(): void
    {
        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new CollectionPropertyExtractor($extractor);

        $actual = $propertyExtractor->registeredType();

        static::assertSame(DataTransferObjectCollection::class, $actual);
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
        $propertyExtractor = new CollectionPropertyExtractor($extractor);

        $actual = $propertyExtractor->extract($dto, $property);

        static::assertNull($actual);
    }

    public function testExtract(): void
    {
        $dto = $this->createMock(DataTransferObject::class);
        $expected = [
            [
                'id' => 10,
                'type' => 'type1',
            ],
            [
                'id' => 20,
                'type' => 'type2',
            ],
            [
                'id' => 30,
                'type' => 'type3',
            ],
        ];
        $dto1 = $this->createTestDto()->setId(10)->setType('type1');
        $dto2 = $this->createTestDto()->setId(20)->setType('type2');
        $dto3 = $this->createTestDto()->setId(30)->setType('type3');

        $collection = $this->createTestDtoCollection([
            $dto1,
            $dto2,
            $dto3,
        ]);

        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getValue')
            ->with($dto)
            ->willReturn($collection);

        $factory = new ExtractorFactory();
        $extractor = $factory();
        $propertyExtractor = new CollectionPropertyExtractor($extractor);

        $actual = $propertyExtractor->extract($dto, $property);

        static::assertSame($expected, $actual);
    }
}