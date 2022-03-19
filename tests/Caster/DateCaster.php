<?php

namespace DtoDragon\Test\Caster;

use DtoDragon\Interfaces\CasterInterface;
use DtoDragon\Test\Dtos\Date;

class DateCaster implements CasterInterface
{
    public function getType(): string
    {
        return Date::class;
    }

    /**
     * @param Date $object
     *
     * @return string
     */
    public function cast(object $object): string
    {
        return $object->day . '-' . $object->month . '-' . $object->year;
    }
}