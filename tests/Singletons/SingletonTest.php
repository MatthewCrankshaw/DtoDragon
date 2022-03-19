<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\CastersSingleton;
use DtoDragon\Singletons\Singleton;
use DtoDragon\Test\DtoDragonTestCase;

class SingletonTest extends DtoDragonTestCase
{
    public function testBasicSingletonInstance(): void
    {
        $instance = Singleton::getInstance();
        $this->assertInstanceOf(Singleton::class, $instance);
    }

    public function testCasterSingletonInstance(): void
    {
        $instance = CastersSingleton::getInstance();
        $this->assertInstanceOf(CastersSingleton::class, $instance);
    }

    public function testInstanceCount(): void
    {
        $singleton = new Singleton();
        $instances = $this->getProtectedProperty($singleton, 'instances');
        $this->assertCount(3, $instances);
    }
}