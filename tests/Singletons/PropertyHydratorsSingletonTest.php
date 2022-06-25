<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Services\Hydrator\DtoHydrator;
use DtoDragon\Services\Strategies\MatchNameStrategy;
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
        $dtoPropertyHydrator = new DtoPropertyHydrator(new DtoHydrator(new MatchNameStrategy()));
        $collectionPropertyHydrator = new CollectionPropertyHydrator(new DtoHydrator(new MatchNameStrategy()));
        $propertyHydrators->register($dtoPropertyHydrator);
        $propertyHydrators->register($collectionPropertyHydrator);

        $propertyHydrators->clear();

        $actual = $this->getProtectedProperty($propertyHydrators, 'propertyHydrators');
        static::assertIsArray($actual);
        static::assertEmpty($actual);
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
        static::assertInstanceOf(PropertyHydratorInterface::class, $hydrator);
    }

    public function testHasDtoPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator(new DtoHydrator(new MatchNameStrategy())));

        $actual = $propertyHydrators->hasPropertyHydrator(get_class($this->createTestDto()));
        static::assertTrue(true, $actual);
    }

    public function testHasCollectionPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new CollectionPropertyHydrator(new DtoHydrator(new MatchNameStrategy())));

        $actual = $propertyHydrators->hasPropertyHydrator(get_class($this->createTestDtoCollection()));
        static::assertTrue(true, $actual);
    }

    /**
     * Test that a DTO property hydrator is able to retrieve a DtoPropertyHydrator for a given Dto subclass
     *
     * @return void
     */
    public function testGetDtoPropertyHydrator(): void
    {
        $propertyHydrators = PropertyHydratorsSingleton::getInstance();
        $propertyHydrators->register(new DtoPropertyHydrator(new DtoHydrator(new MatchNameStrategy())));

        $hydrator = $propertyHydrators->getPropertyHydrator(get_class($this->createTestDto()));
        static::assertInstanceOf(DtoPropertyHydrator::class, $hydrator);
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
        $propertyHydrators->register(new CollectionPropertyHydrator(new DtoHydrator(new MatchNameStrategy())));

        $hydrator = $propertyHydrators->getPropertyHydrator(get_class($this->createTestDtoCollection()));
        static::assertInstanceOf(CollectionPropertyHydrator::class, $hydrator);
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
