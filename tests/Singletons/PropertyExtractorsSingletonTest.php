<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\PropertyExtractor\DatePropertyExtractor;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\Date;

class PropertyExtractorsSingletonTest extends DtoDragonTestCase
{
    private PropertyExtractorsSingleton $propertyExtractors;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->propertyExtractors = PropertyExtractorsSingleton::getInstance();
    }

    public function testRegister(): void
    {
        $this->propertyExtractors->register(new DatePropertyExtractor());
        $propertyExtractors = $this->getProtectedProperty($this->propertyExtractors, 'propertyExtractors');

        $this->assertCount(7, $propertyExtractors);
    }

    public function testGetPropertyExtractor(): void
    {
        $propertyExtractor = $this->propertyExtractors->getPropertyExtractor(Date::class);

        $this->assertInstanceOf(DatePropertyExtractor::class, $propertyExtractor);
    }

    public function testHasPropertyExtractor(): void
    {
        $this->assertTrue($this->propertyExtractors->hasPropertyExtractor(Date::class));
    }

    public function testDoesNotHavePropertyExtractor(): void
    {
        $this->assertFalse($this->propertyExtractors->hasPropertyExtractor(PropertyExtractorsSingletonTest::class));
    }
}