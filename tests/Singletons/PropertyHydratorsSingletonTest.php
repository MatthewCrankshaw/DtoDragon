<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\ServiceCollection;
use DtoDragon\Test\Dtos\ServiceDto;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Utilities\Hydrator\PropertyHydrators\PropertyHydratorInterface;
use ReflectionProperty;

/**
 * Tests to ensure that the property hydrators singleton registers and manages property hydrators correctly
 *
 * @package DtoDragon\Test\Singletons
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
        $this->expectException(\TypeError::class);
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(
            new class {}
        );
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

    /**
     * Test that a DTO property hydrator is able to retrieve a DtoPropertyHydrator for a given Dto subclass
     *
     * @return void
     */
    public function testDtoPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator());

        $hydrator = $propertyHydrators->getPropertyHydrator(ServiceDto::class);
        $this->assertInstanceOf(DtoPropertyHydrator::class, $hydrator);
    }

    /**
     * Test that a collection property hydrators is able to retrieve a CollectionPropertyHydrator
     * for a given Collection subclass
     *
     * @return void
     */
    public function testCollectionPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new CollectionPropertyHydrator());

        $hydrator = $propertyHydrators->getPropertyHydrator(ServiceCollection::class);
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
