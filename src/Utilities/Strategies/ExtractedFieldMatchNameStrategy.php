<?php

namespace DtoDragon\Utilities\Strategies;

/**
 * A field naming strategy that have the extracted array key field match the DTO property name
 *
 * @author Matthew Crankshaw
 */
class ExtractedFieldMatchNameStrategy implements ExtractorNamingStrategyInterface
{
    /**
     * Maintains the DTO field name and sets it as the extracted array key
     *
     * @param string $name
     *
     * @return string
     */
    public function apply(string $name): string
    {
        return $name;
    }
}
