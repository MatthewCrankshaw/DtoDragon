<?php

namespace DtoDragon\Test\Utilities\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Singletons\PropertyHydratorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Test\PropertyHydrator\DatePropertyHydrator;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Extractor\DtoExtractor;
use DtoDragon\Services\Strategies\MatchNameStrategy;

/**
 * @covers \DtoDragon\Utilities\Extractor\DtoExtractor
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
        $namingStrategy = new MatchNameStrategy();
        $extractor = new DtoExtractor($factory, $namingStrategy);

        $actual = $extractor->extract();

        $this->assertIsArray($actual);
    }

    public function testPropertyExtractorNotExist(): void
    {
        $dto = new MultiTypeDto([
            'id' => 10,
            'testString' => 'testing',
        ]);
        PropertyExtractorsSingleton::getInstance()->clear();
        $factory = new DtoReflectorFactory($dto);
        $namingStrategy = new MatchNameStrategy();
        $extractor = new DtoExtractor($factory, $namingStrategy);

        $this->expectException(PropertyExtractorNotFoundException::class);
        $extractor->extract();
    }
}