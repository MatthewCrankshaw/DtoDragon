<?php

namespace DtoDragon\Utilities\Extractor\PropertyExtractors;

/**
 * Extractor for the array type
 * Arrays will be extracted from the dto property to an array using this extractor
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
class ArrayPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'array';
    }
}
