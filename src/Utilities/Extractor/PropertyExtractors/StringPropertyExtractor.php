<?php

namespace DtoDragon\Utilities\Extractor\PropertyExtractors;

/**
 * Extractor for the string type
 * Strings will be extracted from a dto property to an array using this extractor
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
class StringPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'string';
    }
}
