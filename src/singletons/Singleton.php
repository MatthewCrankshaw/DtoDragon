<?php

namespace DtoDragon\singletons;

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