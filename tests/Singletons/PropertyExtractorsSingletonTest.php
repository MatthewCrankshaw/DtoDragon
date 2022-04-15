<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\PropertyExtractor\DatePropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\Date;
use DtoDragon\Test\TestDtos\ServiceCollection;
use DtoDragon\Test\TestDtos\ServiceDto;
use DtoDragon\Utilities\Extractor\PropertyExtractors\CollectionPropertyExtractor;
use DtoDragon\Utilities\Extractor\PropertyExtractors\DtoPropertyExtractor;

/**
 * @covers \DtoDragon\Singletons\PropertyExtractorsSingleton
 * @package DtoDragon\Test\Singletons
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
        $this->singleton->register(new DatePropertyExtractor());

        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        $this->assertNotEmpty($propertyExtractors);

        $this->singleton->clear();
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');
        $this->assertEmpty($propertyExtractors);
    }

    public function testRegister(): void
    {
        $this->singleton->register(new DatePropertyExtractor());
        $propertyExtractors = $this->getProtectedProperty($this->singleton, 'propertyExtractors');

        $this->assertCount(1, $propertyExtractors);
    }

    public function testGetPropertyExtractor(): void
    {
        $propertyExtractor = $this->singleton->getPropertyExtractor(Date::class);

        $this->assertInstanceOf(DatePropertyExtractor::class, $propertyExtractor);
    }

    public function testHasPropertyExtractor(): void
    {
        $this->assertTrue($this->singleton->hasPropertyExtractor(Date::class));
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
        $this->expectException(\Exception::class);
        $this->singleton->getPropertyExtractor(PropertyExtractorsSingletonTest::class);
    }
}