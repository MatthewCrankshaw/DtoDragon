<?php

namespace DtoDragon\Singletons;

/**
 * Base singleton class
 * Manages the singleton instances providing a way of registering and retrieving each singleton
 *
 * @package DtoDragon\singletons
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
     * @example CastersSingleton::getInstance() will return the instance of the CastersSingleton
     *
     * @return Singleton
     */
    public static function getInstance()
    {
        $subclass = static::class;

        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
    }
}
