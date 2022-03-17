<?php

namespace DtoDragon\Test\utilities;

use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\dtos\CalendarItemDto;
use DtoDragon\Test\dtos\Date;
use DtoDragon\utilities\DtoReflector;

class DtoReflectorTest extends DtoDragonTestCase
{
    public function providerCalenderItemDto(): array
    {
        return [
            'basic calendar item' => [[
                'id' => 10,
                'name' => 'hello world',
                'client' => [
                    'id' => 1,
                    'firstName' => 'Romana',
                    'lastName' => 'Petrie',
                ],
                'services' => [
                    [
                        'id' => 3,
                        'type' => 'travel',
                    ]
                ],
                'tags' => [
                    'test 1',
                    'test 2',
                ],
                'date' => new Date(1, 1, 2000),
            ]],
        ];
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesIsArray(array $array): void
    {
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertIsArray($properties);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesCount(array $array): void
    {
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        $this->assertCount(6, $properties);
    }

    /**
     * @dataProvider providerCalenderItemDto
     */
    public function testGetPropertiesPrivate(array $array): void
    {
        $dto = new CalendarItemDto($array);
        $dtoReflector = new DtoReflector($dto);
        $properties = $dtoReflector->getProperties();

        foreach ($properties as $property) {
            $this->assertTrue($property->isPrivate());
        }
    }
}