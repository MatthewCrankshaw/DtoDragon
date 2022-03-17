<?php

namespace DtoDragon\Test\singletons;

use DtoDragon\singletons\CastersSingleton;
use DtoDragon\Test\Caster\DateCaster;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\dtos\Date;

class CastersSingletonTest extends DtoDragonTestCase
{
    private CastersSingleton $casters;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->casters = CastersSingleton::getInstance();
    }

    public function testRegister(): void
    {
        $this->casters->register(new DateCaster());
        $castersProperty = $this->getProtectedProperty($this->casters, 'casters');

        $this->assertCount(1, $castersProperty);
    }

    public function testGetCaster(): void
    {
        $casters = $this->casters->getCaster(new Date(1,1,1));

        $this->assertInstanceOf(DateCaster::class, $casters);
    }

    public function testHasCaster(): void
    {
        $this->assertTrue($this->casters->hasCaster(new Date(1,1,1)));
    }

    public function testDoesNotHaveCaster(): void
    {
        $this->assertFalse($this->casters->hasCaster($this));
    }
}