<?php

namespace DtoDragon\Utilities\Strategies;

/**
 * An interface for a field naming strategy
 * This strategy will apply when a DTO is converted to an array and vise versa
 * The field name will be converted to the array key using the apply method to convert the naming strategy
 *
 * @author Matthew Crankshaw
 */
interface NamingStrategyInterface
{
    /**
     * Applies the naming strategy when converting between DTO field names and array keys
     *
     * @param string $field
     *
     * @return string
     */
    public function fieldToArrayKey(string $field): string;

    public function arrayKeyToField(string $key): string;
}
