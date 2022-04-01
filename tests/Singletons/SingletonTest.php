<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\Singleton;
use DtoDragon\Test\DtoDragonTestCase;

class SingletonTest extends DtoDragonTestCase
{
    public function testBasicSingletonInstance(): void
    {
        $instance = Singleton::getInstance();
        $this->assertInstanceOf(Singleton::class, $instance);
    }

    public function testPropertyExtractorSingletonInstance(): void
    {
        $instance = PropertyExtractorsSingleton::getInstance();
        $this->assertInstanceOf(PropertyExtractorsSingleton::class, $instance);
    }

    public function testInstanceCount(): void
    {
        $singleton = new Singleton();
        $instances = $this->getProtectedProperty($singleton, 'instances');
        $this->assertCount(3, $instances);
    }
}