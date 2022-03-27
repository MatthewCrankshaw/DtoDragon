<?php

namespace DtoDragon\Singletons;

use DtoDragon\DataTransferObject;
use DtoDragon\DataTransferObjectCollection;
use DtoDragon\Exceptions\ParserNotFoundException;
use DtoDragon\Utilities\Hydrator\Parsers\ParserInterface;

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
        $this->parsers[$parser->registeredType()] = $parser;
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
        if ($this->isDto($type)) {
            return isset($this->parsers[DataTransferObject::class]);
        } elseif ($this->isCollection($type)) {
            return isset($this->parsers[DataTransferObjectCollection::class]);
        }

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
     * @throws ParserNotFoundException - If a parser for the type provided does not exist
     * @return object
     */
    public function getParser(string $type): ParserInterface
    {
        if ($this->isDto($type)) {
            return $this->parsers[DataTransferObject::class];
        } elseif ($this->isCollection($type)) {
            return $this->parsers[DataTransferObjectCollection::class];
        }

        if ($this->hasParser($type)) {
            return $this->parsers[$type];
        }

        throw new ParserNotFoundException($type);
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObject
     *
     * @param string $type
     *
     * @return bool
     */
    private function isDto(string $type): bool
    {
        return is_subclass_of($type, DataTransferObject::class);
    }

    /**
     * Check to see if the provided class name is a type of DataTransferObjectCollection
     *
     * @param string $type
     *
     * @return bool
     */
    private function isCollection(string $type): bool
    {
        return is_subclass_of($type, DataTransferObjectCollection::class);
    }
}
