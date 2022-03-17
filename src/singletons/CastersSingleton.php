<?php

namespace DtoDragon\singletons;

use DtoDragon\interfaces\CasterInterface;
use Exception;

class CastersSingleton extends Singleton
{
    /**
     * @var CasterInterface $casters
     */
    private array $casters = [];

    /**
     * @param CasterInterface $caster
     *
     * @return void
     */
    public function register(CasterInterface $caster): void
    {
        if (!in_array($caster, $this->casters)) {
            $this->casters[] = $caster;
        }
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function hasCaster($object): bool
    {
        foreach ($this->casters as $caster) {
            if (is_a($object, $caster->getType())) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $object
     *
     * @throws Exception
     * @return object
     */
    public function getCaster($object): object
    {
        foreach ($this->casters as $caster) {
            if (is_a($object, $caster->getType())) {
                return $caster;
            }
        }

        throw new Exception('Caster was not found for ' . $object::class . '!');
    }
}