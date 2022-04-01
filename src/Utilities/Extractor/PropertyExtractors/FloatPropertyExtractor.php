<?php

namespace DtoDragon\Utilities\Extractor\PropertyExtractors;

/**
 * Extractor for the float type
 * Floats will be extracted from a dto property to an array using this extractor
 *
 * @package DtoDragon\Utilities\Hydrator\PropertyHydrators
 *
 * @author Matthew Crankshaw
 */
class FloatPropertyExtractor extends AbstractPropertyExtractor
{
    /**
     * @inheritDoc
     */
    public function registeredType(): string
    {
        return 'float';
    }
}
