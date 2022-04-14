<?php

namespace DtoDragon\Utilities\Strategies;

/**
 * An interface for a field naming strategy
 * This strategy will apply when a DTO is converted to an array
 * The field name will be converted to the array key using the apply method strategy
 *
 * @author Matthew Crankshaw
 */
interface ExtractorNamingStrategyInterface
{
    /**
     * Applies the naming strategy when converting a DTO field name to the array key
     *
     * @param string $name
     *
     * @return string
     */
    public function apply(string $name): string;
}
