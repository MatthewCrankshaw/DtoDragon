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
     * Test to ensure that when the service provider is not booted the booted flag is false
     *
     * @return void
     */
    public function testNotBooted(): void
    {
        $provider = new DtoServiceProviderSingleton();
        $this->setReflectionPropertyValue($provider, 'booted', false);

        $booted = $this->getProtectedProperty($provider, 'booted');
        $this->assertFalse($booted);
    }

    /**
     * Test to ensure that when the service provider is booted the booted flag is true
     *
     * @return void
     */
    public function testBooted(): void
    {
        $provider = new DtoServiceProviderSingleton();
        $this->setReflectionPropertyValue($provider, 'booted', false);

        $provider->boot();

        $booted = $this->getProtectedProperty($provider, 'booted');
        $this->assertTrue($booted);
    }
}