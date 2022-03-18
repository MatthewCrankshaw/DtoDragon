<?php

namespace DtoDragon\singletons;

/**
 * Base class for DtoDragons singletons
 *
 * @package  DtoDragon\singletons
 *
 * @author   Matthew Crankshaw <mhcrankshaw2@gmail.com>\
 */
class Singleton
{
    private static $instances = [];

    public static function getInstance()
    {
        $subclass = static::class;

        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
    }
}
