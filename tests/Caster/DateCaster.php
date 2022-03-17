<?php

namespace DtoDragon\Test\Caster;

use DtoDragon\interfaces\CasterInterface;
use DtoDragon\Test\dtos\Date;

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