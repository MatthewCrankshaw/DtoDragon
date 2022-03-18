<?php

namespace DtoDragon\interfaces;

use DtoDragon\DataTransferObject;

interface HydratorInterface
{
    public function hydrate(array $data): DataTransferObject;
}
