<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Services\Strategies\MatchNameStrategy;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use DtoDragon\Singletons\NamingStrategySingleton;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * @covers \DtoDragon\Singletons\NamingStrategySingleton
 */
class NamingStrategySingletonTest extends DtoDragonTestCase
{
    public function testRegister(): void
    {
        $singleton = NamingStrategySingleton::getInstance();
        $strategy = $this->createMock(MatchNameStrategy::class);
        $singleton->register($strategy);

        $actual = $this->getProtectedProperty($singleton, 'strategy');

        $this->assertInstanceOf(NamingStrategyInterface::class, $actual);
    }

    public function testGet(): void
    {
        $singleton = NamingStrategySingleton::getInstance();
        $strategy = $this->createMock(MatchNameStrategy::class);
        $singleton->register($strategy);

        $actual = $singleton->get();

        $this->assertInstanceOf(NamingStrategyInterface::class, $actual);
    }
}
