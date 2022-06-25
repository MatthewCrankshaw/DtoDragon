<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Services\Extractor\PropertyExtractors\PrimitivePropertyExtractor;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\Singleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor;
use Exception;

/**
 * @covers \DtoDragon\Singletons\PropertyExtractorsSingleton
 */
class PropertyExtractorsSingletonTest extends DtoDragonTestCase
{
    protected Singleton $singleton;

    public function setUp(): void
    {
        $this->singleton = PropertyExtractorsSingleton::getInstance();
        parent::setUp();
    }

    public function testClear(): void
    {
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        static::assertNotEmpty($propertyExtractors);

        $this->singleton->clear();
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        static::assertEmpty($propertyExtractors);
    }

    public function testRegister(): void
    {
        $this->singleton->register(new PrimitivePropertyExtractor());
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');

        static::assertCount(1, $propertyExtractors);
    }

    public function testGetPropertyExtractor(): void
    {
        $this->singleton->register(new PrimitivePropertyExtractor());
        $propertyExtractor = $this->singleton->getPropertyExtractor('int');

        static::assertInstanceOf(PrimitivePropertyExtractor::class, $propertyExtractor);
    }

    public function testHasPropertyExtractor(): void
    {
        static::assertTrue($this->singleton->hasPropertyExtractor('int'));
    }

    public function testHasDtoPropertyExtractor(): void
    {
        $this->singleton->register(new DtoPropertyExtractor());
        static::assertTrue($this->singleton->hasPropertyExtractor(get_class($this->createTestDto())));
    }

    public function testHasCollectionPropertyExtractor(): void
    {
        $this->singleton->register(new CollectionPropertyExtractor());
        static::assertTrue($this->singleton->hasPropertyExtractor(get_class($this->createTestDtoCollection())));
    }

    public function testDoesNotHavePropertyExtractor(): void
    {
        static::assertFalse($this->singleton->hasPropertyExtractor(PropertyExtractorsSingletonTest::class));
    }

    public function testGetDtoPropertyExtractor(): void
    {
        $this->singleton->register(new DtoPropertyExtractor());

        $extractor = $this->singleton->getPropertyExtractor(get_class($this->createTestDto()));
        static::assertInstanceOf(DtoPropertyExtractor::class, $extractor);
    }

    public function testGetCollectionPropertyController(): void
    {
        $this->singleton->register(new CollectionPropertyExtractor());

        $extractor = $this->singleton->getPropertyExtractor(get_class($this->createTestDtoCollection()));
        static::assertInstanceOf(CollectionPropertyExtractor::class, $extractor);
    }

    public function testCannotGetPropertyExtractor(): void
    {
        $this->expectException(Exception::class);
        $this->singleton->getPropertyExtractor(PropertyExtractorsSingletonTest::class);
    }
}