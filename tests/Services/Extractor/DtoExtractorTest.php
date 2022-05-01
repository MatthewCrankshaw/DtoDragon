<?php

namespace DtoDragon\Test\Services\Extractor;

use DtoDragon\Exceptions\PropertyExtractorNotFoundException;
use DtoDragon\Services\Strategies\NamingStrategyInterface;
use DtoDragon\Singletons\NamingStrategySingleton;
use DtoDragon\Singletons\PropertyExtractorsSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\TestDtos\MultiTypeDto;
use DtoDragon\Services\DtoReflectorFactory;
use DtoDragon\Services\Extractor\DtoExtractor;
use DtoDragon\Services\Strategies\MatchNameStrategy;

/**
 * @covers \DtoDragon\Services\Extractor\DtoExtractor
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

    public function testCreateNamingStrategy(): void
    {
        NamingStrategySingleton::getInstance()->register(new MatchNameStrategy());
        $factory = $this->createMock(DtoReflectorFactory::class);
        $extractor = new DtoExtractor($factory);

        $actual = $this->callProtectedMethod($extractor, 'createNamingStrategy', []);
        $this->assertInstanceOf(NamingStrategyInterface::class, $actual);
    }
}