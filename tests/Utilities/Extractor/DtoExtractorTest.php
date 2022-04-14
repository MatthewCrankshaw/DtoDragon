<?php

namespace DtoDragon\Test\Utilities\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Test\PropertyHydrator\DatePropertyHydrator;
use DtoDragon\Utilities\DtoReflectorFactory;
use DtoDragon\Utilities\Extractor\DtoExtractor;
use DtoDragon\Utilities\Strategies\ExtractedFieldMatchNameStrategy;

/**
 * @covers \DtoDragon\Utilities\Extractor\DtoExtractor
 * @package DtoDragon\Test\Utilities\Extractor
 */
class DtoExtractorTest extends DtoDragonTestCase
{
    public function provideExtract():array
    {
        return [
            'flat extract' => [
                [
                    'id' => 10,
                    'testString' => 'this is a string',
                    'date' => '12-05-2012',
                ]
            ],
        ];
    }

    /**
     * @dataProvider provideExtract
     */
    public function testExtract(array $data): void
    {
        $dto = new MultiTypeDto($data);
        $factory = new DtoReflectorFactory($dto);
        $namingStrategy = new ExtractedFieldMatchNameStrategy();
        $extractor = new DtoExtractor($factory, $namingStrategy);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }

    public function testPropertyExtractorNotExist(): void
    {
        PropertyExtractorsSingleton::getInstance()->clear();
        PropertyHydratorsSingleton::getInstance()->register(new DatePropertyHydrator());
        $dto = new MultiTypeDto([
            'id' => 10,
            'testString' => 'testing',
            'date' => '12-05-2012',
        ]);
        $factory = new DtoReflectorFactory($dto);
        $namingStrategy = new ExtractedFieldMatchNameStrategy();
        $extractor = new DtoExtractor($factory, $namingStrategy);

        $this->expectException(PropertyExtractorNotFoundException::class);
        $extractor->extract();
    }
}