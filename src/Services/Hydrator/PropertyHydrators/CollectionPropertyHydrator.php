<?php

namespace DtoDragon\Services\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObjectCollection;
use ReflectionProperty;

/**
 * Property hydrator that converts array data to a data transfer object collection
 *
 * @author Matthew Crankshaw
 */
class CollectionPropertyHydrator implements PropertyHydratorInterface
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return DataTransferObjectCollection::class;
    }

    /**
     * Parse an array of data to a DataTransferObjectCollection
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObjectCollection
     */
    public function hydrate(ReflectionProperty $property, $value)
    {
        $propertyType = $property->getType();
        $collection = $propertyType->getName();
        $collectArray = [];
        foreach ($value as $item) {
            $dtoType = $collection::dtoType();
            $collectArray[] = new $dtoType($item);
        }
        return new $collection($collectArray);
    }
}
