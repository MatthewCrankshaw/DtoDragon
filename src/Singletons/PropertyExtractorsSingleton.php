<?php

namespace DtoDragon\Singletons;

use DtoDragon\Utilities\Extractor\PropertyExtractors\PropertyExtractorInterface;
use Exception;

/**
 * Singleton to manage an array of property extractors
 * The property extractors will be responsible for extracting properties from a DTO to an array item
 *
 * @package DtoDragon\Singletons
 *
 * @author Matthew Crankshaw
 */
class PropertyExtractorsSingleton extends Singleton
{
    /**
     * The array of property extractors
     *
     * @var PropertyExtractorInterface[] $propertyExtractors
     */
    private array $propertyExtractors = [];

    /**
     * Registers a new property extractor for this singleton to manage
     *
     * @param PropertyExtractorInterface $propertyExtractor
     *
     * @return void
     */
    public function register(PropertyExtractorInterface $propertyExtractor): void
    {
        if (!in_array($propertyExtractor, $this->propertyExtractors)) {
            $this->propertyExtractors[$propertyExtractor->registeredType()] = $propertyExtractor;
        }
    }

    /**
     * Returns true if there is a property extractor for this object type
     *
     * @param object $object
     *
     * @return bool
     */
    public function hasPropertyExtractor(object $object): bool
    {
        if (isset($this->propertyExtractors[$object::class])) {
            return true;
        }
        return false;
    }

    /**
     * Get the property extractor based on the object's type provided
     *
     * @param object $object
     *
     * @throws Exception - If a property extractor for the type provided does not exist
     * @return PropertyExtractorInterface
     */
    public function getPropertyExtractor(object $object): PropertyExtractorInterface
    {
        if ($this->hasPropertyExtractor($object)) {
            return $this->propertyExtractors[$object::class];
        }

        throw new Exception('Property extractor was not found for ' . $object::class . '!');
    }
}
