<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\Singleton;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Singletons\Singleton
 */
class SingletonTest extends DtoDragonTestCase
{
    public function testBasicSingletonInstance(): void
    {
        $instance = Singleton::getInstance();
        static::assertInstanceOf(Singleton::class, $instance);
    }

    public function testPropertyExtractorSingletonInstance(): void
    {
        $instance = PropertyExtractorsSingleton::getInstance();
        static::assertInstanceOf(PropertyExtractorsSingleton::class, $instance);
    }

    public function testInstanceCount(): void
    {
        $singleton = new Singleton();
        $instances = $this->getProtectedProperty($singleton, 'instances');
        static::assertCount(5, $instances);
    }
}