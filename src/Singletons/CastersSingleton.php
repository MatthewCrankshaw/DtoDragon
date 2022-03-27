<?php

namespace DtoDragon\Singletons;

use DtoDragon\Utilities\Extractor\Casters\CasterInterface;
use Exception;

/**
 * Singleton to manage an array of casters
 * The casters will be responsible for casting an object to string
 *
 * @package DtoDragon\Singletons
 *
 * @author Matthew Crankshaw
 */
class CastersSingleton extends Singleton
{
    /**
     * The array of Casters
     *
     * @var CasterInterface[] $casters
     */
    private array $casters = [];

    /**
     * Registers a new caster for this singleton to manage
     *
     * @param CasterInterface $caster
     *
     * @return void
     */
    public function register(CasterInterface $caster): void
    {
        if (!in_array($caster, $this->casters)) {
            $this->casters[$caster->getType()] = $caster;
        }
    }

    /**
     * Returns true if there is a caster for this object type
     *
     * @param object $object
     *
     * @return bool
     */
    public function hasCaster(object $object): bool
    {
        if (isset($this->casters[$object::class])) {
            return true;
        }
        return false;
    }

    /**
     * Get the caster based on the object's type provided
     *
     * @param object $object
     *
     * @throws Exception - If a caster for the type provided does not exist
     * @return CasterInterface
     */
    public function getCaster(object $object): CasterInterface
    {
        if ($this->hasCaster($object)) {
            return $this->casters[$object::class];
        }

        throw new Exception('Caster was not found for ' . $object::class . '!');
    }
}
