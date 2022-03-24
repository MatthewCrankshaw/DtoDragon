<?php

namespace DtoDragon\Test\Singletons;

use DtoDragon\Exceptions\ParserNotFoundException;
use DtoDragon\Interfaces\ParserInterface;
use DtoDragon\Singletons\ParsersSingleton;
use DtoDragon\Test\DtoDragonTestCase;
use DtoDragon\Test\Dtos\ServiceCollection;
use DtoDragon\Test\Dtos\ServiceDto;
use DtoDragon\Utilities\Hydrator\Parsers\CollectionParser;
use DtoDragon\Utilities\Hydrator\Parsers\DtoParser;
use ReflectionProperty;

/**
 * Tests to ensure that the parser singleton registers and manages parsers correctly
 *
 * @package DtoDragon\Test\Singletons
 *
 * @author Matthew Crankshaw
 */
class ParsersSingletonTest extends DtoDragonTestCase
{
    /**
     * Expect a type exception when trying to register a non-Parser
     *
     * @return void
     */
    public function testRegisterNonParser(): void
    {
        $this->expectException(\TypeError::class);
        $parsers = ParsersSingleton::getInstance();
        $parsers->register(
            new class {}
        );
    }

    /**
     * Successfully register a parser
     *
     * @return void
     */
    public function testRegisterParser(): void
    {
        $parsers = ParsersSingleton::getInstance();
        $parsers->register(
            new class implements ParserInterface  {

                public function getTypes(): array
                {
                    return ['type'];
                }

                public function parse(ReflectionProperty $property, $value)
                {
                    return null;
                }
            }
        );

        $parser = $parsers->getParser('type');
        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    /**
     * Successfully register a multi-type parser
     * All the types will return the same parser
     *
     * @return void
     */
    public function testRegisterMultiTypeParser(): void
    {
        $parsers = ParsersSingleton::getInstance();
        $parsers->register(
            new class implements ParserInterface  {

                public function getTypes(): array
                {
                    return ['type1', 'type2', 'type3'];
                }

                public function parse(ReflectionProperty $property, $value)
                {
                    return null;
                }
            }
        );

        $parser1 = $parsers->getParser('type1');
        $parser2 = $parsers->getParser('type2');
        $parser3 = $parsers->getParser('type3');

        $this->assertInstanceOf(ParserInterface::class, $parser1);
        $this->assertInstanceOf(ParserInterface::class, $parser2);
        $this->assertInstanceOf(ParserInterface::class, $parser3);

        $this->assertSame($parser1, $parser2);
        $this->assertSame($parser2, $parser3);
    }

    /**
     * Test that a DTO parser is able to retrieve a DtoParser for a given Dto subclass
     *
     * @return void
     */
    public function testDtoParser(): void
    {
        $parsers = ParsersSingleton::getInstance();
        $parsers->register(new DtoParser());

        $parser = $parsers->getParser(ServiceDto::class);
        $this->assertInstanceOf(DtoParser::class, $parser);
    }

    /**
     * Test that a collection parser is able to retrieve a CollectionParser for a given Collection subclass
     *
     * @return void
     */
    public function testCollectionParser(): void
    {
        $parsers = ParsersSingleton::getInstance();
        $parsers->register(new CollectionParser());

        $parser = $parsers->getParser(ServiceCollection::class);
        $this->assertInstanceOf(CollectionParser::class, $parser);
    }

    /**
     * Ensure that when a non-existant type is provided the parser will throw the appropriate exception
     *
     * @return void
     */
    public function testParserNotFound(): void
    {
        $this->expectException(ParserNotFoundException::class);
        $parsers = ParsersSingleton::getInstance();
        $parsers->getParser('non existant type');
    }
}
