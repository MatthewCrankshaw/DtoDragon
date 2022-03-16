<?php

namespace DtoDragon\interfaces;

use ReflectionProperty;

interface DtoReflectorInterface
{
    public function getProperties(): array;

    public function getProperty(ReflectionProperty $property);

    public function setProperty(ReflectionProperty $property, $value);
}