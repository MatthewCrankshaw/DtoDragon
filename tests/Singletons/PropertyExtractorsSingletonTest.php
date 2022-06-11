<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\ServiceCollection;
use DtoDragon\Test\TestDtos\ServiceDto;
use DtoDragon\Services\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\DtoPropertyExtractor;
use DtoDragon\Services\Extractor\PropertyExtractors\IntegerPropertyExtractor;
use Exception;

/**
 * @covers \DtoDragon\Singletons\PropertyExtractorsSingleton
 */
class PropertyExtractorsSingletonTest extends DtoDragonTestCase
{
    private PropertyExtractorsSingleton $singleton;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->singleton = PropertyExtractorsSingleton::getInstance();
    }

    public function testClear(): void
    {
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        $this->assertNotEmpty($propertyExtractors);

        $this->singleton->clear();
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        $this->assertEmpty($propertyExtractors);
    }

    public function testRegister(): void
    {
        $this->singleton->register(new IntegerPropertyExtractor());
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');

        $this->assertCount(1, $propertyExtractors);
    }

    public function testGetPropertyExtractor(): void
    {
        $this->singleton->register(new IntegerPropertyExtractor());
        $propertyExtractor = $this->singleton->getPropertyExtractor('int');

        $this->assertInstanceOf(IntegerPropertyExtractor::class, $propertyExtractor);
    }

    public function testHasPropertyExtractor(): void
    {
        $this->assertTrue($this->singleton->hasPropertyExtractor('int'));
    }

    public function testHasDtoPropertyExtractor(): void
    {
        $this->singleton->register(new DtoPropertyExtractor());
        $this->assertTrue($this->singleton->hasPropertyExtractor(ServiceDto::class));
    }

    public function testHasCollectionPropertyExtractor(): void
    {
        $this->singleton->register(new CollectionPropertyExtractor());
        $this->assertTrue($this->singleton->hasPropertyExtractor(ServiceCollection::class));
    }

    public function testDoesNotHavePropertyExtractor(): void
    {
        $this->assertFalse($this->singleton->hasPropertyExtractor(PropertyExtractorsSingletonTest::class));
    }

    public function testGetDtoPropertyExtractor(): void
    {
        $this->singleton->register(new DtoPropertyExtractor());

        $extractor = $this->singleton->getPropertyExtractor(ServiceDto::class);
        $this->assertInstanceOf(DtoPropertyExtractor::class, $extractor);
    }

    public function testGetCollectionPropertyController(): void
    {
        $this->singleton->register(new CollectionPropertyExtractor());

        $extractor = $this->singleton->getPropertyExtractor(ServiceCollection::class);
        $this->assertInstanceOf(CollectionPropertyExtractor::class, $extractor);
    }

    public function testCannotGetPropertyExtractor(): void
    {
        $this->expectException(Exception::class);
        $this->singleton->getPropertyExtractor(PropertyExtractorsSingletonTest::class);
    }
}