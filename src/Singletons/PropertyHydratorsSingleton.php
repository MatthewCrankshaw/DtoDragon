<?php

namespace DtoDragon\Singletons;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Exceptions\PropertyHydratorNotFoundException;
use DtoDragon\Services\Hydrator\PropertyHydrators\PropertyHydratorInterface;

/**
 * Singleton to manage an array of property hydrators
 * The property hydrators will be responsible for hydrating  to an object
 *
 * @author Matthew Crankshaw
 */
class PropertyHydratorsSingleton extends Singleton
{
    /**
     * The array of property hydrators to manage
     *
     * @var PropertyHydratorInterface[] $propertyHydrators
     */
    private array $propertyHydrators = [];

    /**
     * Clear all the hydrators managed by this singleton
     *
     * @return void
     */
    public function clear(): void
    {
        $this->propertyHydrators = [];
        DtoServiceProviderSingleton::getInstance()->setBooted(false);
    }

    /**
     * Registers a new property hydrator for this singleton to manage
     *
     * @param PropertyHydratorInterface $propertyHydrator
     *
     * @return void
     */
    public function register(PropertyHydratorInterface $propertyHydrator): void
    {
        $this->propertyHydrators[$propertyHydrator->registeredType()] = $propertyHydrator;
    }

    /**
     * Returns true if there is a property hydrator for this object type
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasPropertyHydrator(string $type): bool
    {
        if ($this->isDto($type)) {
            return isset($this->propertyHydrators[DataTransferObject::class]);
        } elseif ($this->isCollection($type)) {
            return isset($this->propertyHydrators[DataTransferObjectCollection::class]);
        }

        if (isset($this->propertyHydrators[$type])) {
            return true;
        }
        return false;
    }

    /**
     * Get the property hydrator based on the object's type provided
     *
     * @param string $type
     *
     * @throws PropertyHydratorNotFoundException - If a property hydrator for the type provided does not exist
     * @return PropertyHydratorInterface
     */
    public function getPropertyHydrator(string $type): PropertyHydratorInterface
    {
        if ($this->isDto($type)) {
            return $this->propertyHydrators[DataTransferObject::class];
        } elseif ($this->isCollection($type)) {
            return $this->propertyHydrators[DataTransferObjectCollection::class];
        }

        if ($this->hasPropertyHydrator($type)) {
            return $this->propertyHydrators[$type];
        }

        throw new PropertyHydratorNotFoundException($type);
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObject
     *
     * @param string $type
     *
     * @return bool
     */
    private function isDto(string $type): bool
    {
        return is_subclass_of($type, DataTransferObject::class);
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObjectCollection
     *
     * @param string $type
     *
     * @return bool
     */
    private function isCollection(string $type): bool
    {
        return is_subclass_of($type, DataTransferObjectCollection::class);
    }
}
