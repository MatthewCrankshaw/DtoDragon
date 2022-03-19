<?php

namespace DtoDragon\Singletons;

use DtoDragon\Interfaces\ParserInterface;
use Exception;

/**
 * Singleton to manage an array of parsers
 * The parsers will be responsible for parsing a string to an object
 *
 * @package DtoDragon\Singletons
 *
 * @author Matthew Crankshaw
 */
class ParsersSingleton extends Singleton
{
    /**
     * The array of parsers to manage
     *
     * @var ParserInterface[] $parsers
     */
    private array $parsers = [];

    /**
     * Registers a new parser for this singleton to manage
     *
     * @param ParserInterface $parser
     *
     * @return void
     */
    public function register(ParserInterface $parser): void
    {
        if (!in_array($parser, $this->parsers)) {
            $this->parsers[$parser->getType()] = $parser;
        }
    }

    /**
     * Returns true if there is a parser for this object type
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasParser(string $type): bool
    {
        if (isset($this->parsers[$type])) {
            return true;
        }
        return false;
    }

    /**
     * Get the parser based on the object's type provided
     *
     * @param string $type
     *
     * @throws Exception - If a parser for the type provided does not exist
     * @return object
     */
    public function getParser(string $type): ParserInterface
    {
        if ($this->hasParser($type)) {
            return $this->parsers[$type];
        }

        throw new Exception('Parser was not found for ' . $type . '!');
    }
}