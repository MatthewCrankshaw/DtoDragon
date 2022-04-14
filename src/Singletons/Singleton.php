<?php

namespace DtoDragon\Singletons;

/**
 * Base singleton class
 * Manages the singleton instances providing a way of registering and retrieving each singleton
 *
 * @package DtoDragon\Singletons
 *
 * @author Matthew Crankshaw
 */
class Singleton
{
    /**
     * Array of singleton instances
     *
     * @var Singleton[]
     */
    private static $instances = [];

    /**
     * Get the instance of the singleton
     * As this is late statically binded the subclass will be overriden
     * @example PropertyExtractorsSingleton::getInstance() will return the instance of the PropertyExtractorsSingleton
     *
     * @return Singleton
     */
    public static function getInstance(): Singleton
    {
        $subclass = static::class;

        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
    }
}
