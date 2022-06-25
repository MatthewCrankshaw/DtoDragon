<?php

namespace DtoDragon\Test\Services\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObject;
use DtoDragon\Services\Hydrator\DtoHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Services\Strategies\MatchNameStrategy;
use DtoDragon\Test\ConcreteDto;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * @covers \DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator
 */
class DtoPropertyHydratorTest extends DtoDragonTestCase
{
    public function testConstruct(): void
    {
        $dtoHydrator = $this->createMock(DtoHydrator::class);
        $hydrator = new DtoPropertyHydrator($dtoHydrator);

        static::assertInstanceOf(DtoPropertyHydrator::class, $hydrator);
    }

    public function testRegisteredType(): void
    {
        $dtoHydrator = $this->createMock(DtoHydrator::class);
        $hydrator = new DtoPropertyHydrator($dtoHydrator);
        static::assertSame(DataTransferObject::class, $hydrator->registeredType());
    }

    public function testHydrate(): void
    {
        $data = [];

        $dto = $this->createMock(ConcreteDto::class);
        $type = $this->createMock(ReflectionNamedType::class);
        $type->expects(static::once())
            ->method('getName')
            ->willReturn(ConcreteDto::class);

        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getType')
            ->willReturn($type);

        $dtoHydrator = $this->createMock(DtoHydrator::class);
        $dtoHydrator->expects(static::once())
            ->method('hydrate')
            ->willReturn($dto);

        $hydrator = new DtoPropertyHydrator($dtoHydrator);
        $actual = $hydrator->hydrate($property, $data);

        static::assertInstanceOf(ConcreteDto::class, $actual);
    }

    public function testCreateDto(): void
    {
        $hydrator = new DtoPropertyHydrator(new DtoHydrator(new MatchNameStrategy()));
        $actual = $this->callProtectedMethod($hydrator, 'createDto', [ConcreteDto::class]);

        static::assertInstanceOf(ConcreteDto::class, $actual);
    }
}