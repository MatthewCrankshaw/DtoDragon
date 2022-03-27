<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use DtoDragon\DataTransferObjectCollection;
use ReflectionProperty;

/**
 * Parser that converts array data to a data transfer object collection
 *
 * @package DtoDragon\Utilities\Hydrator\Parsers
 *
 * @author Matthew Crankshaw
 */
class CollectionParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function registerTypes(): array
    {
        return [DataTransferObjectCollection::class];
    }

    /**
     * Parse an array of data to a DataTransferObjectCollection
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return DataTransferObjectCollection
     */
    public function parse(ReflectionProperty $property, $value)
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
