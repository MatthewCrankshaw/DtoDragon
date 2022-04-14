<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\DtoServiceProviderSingleton;
use DtoDragon\Test\DtoDragonTestCase;

/**
 * Test the DTO service provider
 *
 * @covers \DtoDragon\Singletons\DtoServiceProviderSingleton
 */
class DtoServiceProviderSingletonTest extends DtoDragonTestCase
{
    /**
     * Test to ensure that when the service provider is booted the booted flag is true
     *
     * @return void
     */
    public function testBooted(): void
    {
        $provider = $this->getMockBuilder(DtoServiceProviderSingleton::class)
            ->onlyMethods(['boot'])
            ->getMock();

        $provider->expects($this->once())
            ->method('boot');

        $provider->boot();
    }
}