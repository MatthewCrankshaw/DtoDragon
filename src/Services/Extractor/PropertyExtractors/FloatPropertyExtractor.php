<?php

namespace DtoDragon\Services\Extractor\PropertyExtractors;

/**
 * Extractor for the float type
 * Floats will be extracted from a dto property to an array using this extractor
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
