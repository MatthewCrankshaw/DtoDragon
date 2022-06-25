<?php

namespace DtoDragon\Test\Services\Hydrator\PropertyHydrators;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Services\Hydrator\DtoHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\CollectionPropertyHydrator;
use DtoDragon\Services\Hydrator\PropertyHydrators\DtoPropertyHydrator;
use DtoDragon\Services\Strategies\MatchNameStrategy;
use DtoDragon\Test\ConcreteCollection;
use DtoDragon\Test\ConcreteDto;
use DtoDragon\Test\DtoDragonTestCase;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * @covers \DtoDragon\Services\Hydrator\PropertyHydrators\CollectionPropertyHydrator
 */
class CollectionPropertyHydratorTest extends DtoDragonTestCase
{
    public function testRegisteredType(): void
    {
        $hydrator = new CollectionPropertyHydrator(new DtoHydrator(new MatchNameStrategy()));
        static::assertSame(DataTransferObjectCollection::class, $hydrator->registeredType());
    }

    public function testHydrate(): void
    {
        $dto1 = $this->createTestDto();
        $dto1->setId(1)->setType('string');

        $dto2 = $this->createTestDto();
        $dto2->setId(2)->setType('string2');

        $value = [
            [
                'id' => 1,
                'type' => 'string'
            ],
            [
                'id' => 2,
                'type' => 'string2'
            ],
        ];

        $collection = $this->createTestDtoCollection();
        $property = $this->createMock(ReflectionProperty::class);
        $hydrator = $this->createPartialMock(
            CollectionPropertyHydrator::class,
            ['newCollection', 'hydrateDto']
        );

        $hydrator->expects(static::once())
            ->method('newCollection')
            ->with($property)
            ->willReturn($collection);

        $hydrator->expects(static::exactly(2))
            ->method('hydrateDto')
            ->withConsecutive([$collection, $value[0]], [$collection, $value[1]])
            ->willReturnOnConsecutiveCalls($dto1, $dto2);

        $actual = $hydrator->hydrate($property, $value);

        static::assertInstanceOf(DataTransferObjectCollection::class, $actual);
        static::assertCount(2, $actual);
        static::assertSame($dto1, $actual->items()[0]);
        static::assertSame($dto2, $actual->items()[1]);
    }

    public function testNewCollection(): void
    {
        $propertyType = $this->createMock(ReflectionNamedType::class);
        $propertyType->expects(static::once())
            ->method('getName')
            ->willReturn(ConcreteCollection::class);

        $property = $this->createMock(ReflectionProperty::class);
        $property->expects(static::once())
            ->method('getType')
            ->willReturn($propertyType);

        $hydrator = new CollectionPropertyHydrator(new DtoHydrator(new MatchNameStrategy()));

        $actual = $this->callProtectedMethod($hydrator, 'newCollection', [$property]);

        static::assertInstanceOf(ConcreteCollection::class, $actual);
    }

    public function testHydrateDto(): void
    {
        $data = [];
        $dto = $this->createMock(DataTransferObject::class);

        $collection = $this->createMock(ConcreteCollection::class);
        $collection->expects(static::once())
            ->method('dtoType')
            ->willReturn(ConcreteDto::class);

        $dtoHydrator = $this->createMock(DtoHydrator::class);
        $dtoHydrator->expects(static::once())
            ->method('hydrate')
            ->with(new ConcreteDto(), $data)
            ->willReturn($dto);

        $hydrator = new CollectionPropertyHydrator($dtoHydrator);
        $actual = $this->callProtectedMethod($hydrator, 'hydrateDto', [$collection, $data]);
    }
}