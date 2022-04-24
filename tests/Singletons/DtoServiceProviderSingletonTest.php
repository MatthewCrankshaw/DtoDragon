<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\DtoServiceProviderSingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\Hydrator\PropertyHydrators\IntegerPropertyHydrator;

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
        $provider = DtoServiceProviderSingleton::getInstance();

        $provider->boot();

        $booted = $this->getProtectedProperty($provider, 'booted');
        $this->assertTrue($booted);
    }
}