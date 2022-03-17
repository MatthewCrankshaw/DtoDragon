<?php

namespace DtoDragon\interfaces;

interface CasterInterface
{
    public function getType(): string;

    public function cast(object $object): string;
}