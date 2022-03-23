<?php

namespace DtoDragon\Utilities\Hydrator\Parsers;

use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Interfaces\ParserInterface;
use ReflectionProperty;

class CollectionParser implements ParserInterface
{
    public function getTypes(): array
    {
        return [DataTransferObjectCollection::class];
    }

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
