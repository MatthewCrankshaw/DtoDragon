<?php

namespace DtoDragon\Services\Strategies;

/**
 * A field naming strategy that have the extracted array key field match the DTO property name
 *
 * @author Matthew Crankshaw
 */
class MatchNameStrategy implements NamingStrategyInterface
{
    /**
     * Maintains the DTO field name and sets it as the extracted array key
     *
     * @param string $field
     *
     * @return string
     */
    public function fieldToArrayKey(string $field): string
    {
        return $field;
    }

    /**
     * Maintains the array key name and sets it as the extracted field name
     *
     * @param string $key
     *
     * @return string
     */
    public function arrayKeyToField(string $key): string
    {
        return $key;
    }
}
