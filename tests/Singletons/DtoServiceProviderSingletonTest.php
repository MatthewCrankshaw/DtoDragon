<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Singletons\DtoServiceProviderSingleton;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use Mockery;

/**
 * Test the DTO service provider
 *
 * @covers \DtoDragon\Singletons\DtoServiceProviderSingleton
 */
class DtoServiceProviderSingletonTest extends DtoDragonTestCase
{
    public function testClear(): void
    {
        $provider = DtoServiceProviderSingleton::getInstance();

        $hydrators = Mockery::mock(PropertyHydratorsSingleton::class);
        $hydrators->shouldReceive('getInstance')
            ->once()
            ->andReturnSelf();
        $hydrators->shouldReceive('clear')
            ->once();

        $extractors = Mockery::mock(PropertyExtractorsSingleton::class);
        $extractors->shouldReceive('getInstance')
            ->once()
            ->andReturnSelf();
        $extractors->shouldReceive('clear')
            ->once();

        $provider->clear();

        $actual = $this->getProtectedProperty($provider, 'booted');
        static::assertFalse($actual);
    }

    /**
     * Test to ensure that when the service provider is booted the booted flag is true
     *
     * @return void
     */
    public function testBooted(): void
    {
        $provider = DtoServiceProviderSingleton::getInstance();
        $this->setReflectionPropertyValue($provider, 'booted', false);

        $provider->boot();

        $booted = $this->getProtectedProperty($provider, 'booted');
        static::assertTrue($booted);
    }

    public function provideSetBooted(): array
    {
        return [
            'is booted' => [
                true,
                true,
            ],
            'is not booted' => [
                false,
                false,
            ]
        ];
    }

    /**
     * @dataProvider provideSetBooted
     * @return void
     */
    public function testSetBooted(bool $booted, bool $expected): void
    {
        $provider = DtoServiceProviderSingleton::getInstance();

        $provider->setBooted($booted);

        $booted = $this->getProtectedProperty($provider, 'booted');
        static::assertEquals($expected, $booted);
    }
}