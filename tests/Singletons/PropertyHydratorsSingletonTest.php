<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Services\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\PropertyHydratorInterface;
use ReflectionProperty;
use TypeError;

/**
 * Tests to ensure that the property hydrators singleton registers and manages property hydrators correctly
 *
 * @covers \DtoDragon\Singletons\PropertyHydratorsSingleton
 *
 * @author Matthew Crankshaw
 */
class PropertyHydratorsSingletonTest extends DtoDragonTestCase
{
    /**
     * Expect a type exception when trying to register a non property hydrator
     *
     * @return void
     */
    public function testRegisterNonPropertyHydrators(): void
    {
        $this->expectException(TypeError::class);
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(
            new class {}
        );
    }

    public function testClear(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator());
        $propertyHydrators->register(new CollectionPropertyHydrator());

        $propertyHydrators->clear();

        $actual = $this->getProtectedProperty($propertyHydrators, 'propertyHydrators');
        $this->assertIsArray($actual);
        $this->assertEmpty($actual);
    }

    /**
     * Successfully register a property hydrator
     *
     * @return void
     */
    public function testRegisterPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(
            new class implements PropertyHydratorInterface  {

                public function registeredType(): string
                {
                    return 'type';
                }

                public function hydrate(ReflectionProperty $property, $value)
                {
                    return null;
                }
            }
        );

        $hydrator = $propertyHydrators->getPropertyHydrator('type');
        $this->assertInstanceOf(PropertyHydratorInterface::class, $hydrator);
    }

    public function testHasDtoPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator());

        $actual = $propertyHydrators->hasPropertyHydrator(get_class($this->createTestDto()));
        $this->assertTrue(true, $actual);
    }

    public function testHasCollectionPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new CollectionPropertyHydrator());

        $actual = $propertyHydrators->hasPropertyHydrator(get_class($this->createTestDtoCollection()));
        $this->assertTrue(true, $actual);
    }

    /**
     * Test that a DTO property hydrator is able to retrieve a DtoPropertyHydrator for a given Dto subclass
     *
     * @return void
     */
    public function testGetDtoPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator());

        $hydrator = $propertyHydrators->getPropertyHydrator(get_class($this->createTestDto()));
        $this->assertInstanceOf(DtoPropertyHydrator::class, $hydrator);
    }

    /**
     * Test that a collection property hydrators is able to retrieve a CollectionPropertyHydrator
     * for a given Collection subclass
     *
     * @return void
     */
    public function testGetCollectionPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new CollectionPropertyHydrator());

        $hydrator = $propertyHydrators->getPropertyHydrator(get_class($this->createTestDtoCollection()));
        $this->assertInstanceOf(CollectionPropertyHydrator::class, $hydrator);
    }

    /**
     * Ensure that when a non-existant type is provided
     * the property hydrator will throw the appropriate exception
     *
     * @return void
     */
    public function testPropertyHydratorNotFound(): void
    {
        $this->expectException(PropertyHydratorNotFoundException::class);
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->getPropertyHydrator('non existant type');
    }
}
