<?php

namespace DtoDragon;

use Iterator;

/**
 * The base implementation of a DTO collection
 * All DTO collections will extend this class
 * Contains utilities for iterating and handling a collection of DTO's
 *
 * @author Matthew Crankshaw
 */
abstract class DataTransferObjectCollection implements Iterator
{
    /**
     * The current position in the array
     * Necessary for iterating through items
     *
     * @var int
     */
    protected int $position;

    /**
     * The array of DTO items
     *
     * @var DataTransferObject[]
     */
    protected array $items = [];

    /**
     * Construct a data transfer object collection
     *
     * @param DataTransferObject[] $items
     */
    public function __construct(array $items = [])
    {
        $this->position = 0;
        $this->items = $items;
    }

    /**
     * Returns the class of the DTO that this collection manages
     *
     * @return string
     */
    abstract public function dtoType(): string;

    /**
     * Get the current data transfer object
     *
     * @return DataTransferObject
     */
    public function current(): DataTransferObject
    {
        return $this->items[$this->position];
    }

    /**
     * Set the position to be the next item in the array
     *
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Return the key of the current item in the array
     *
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Check if the item in the array is set
     *
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Return the position to the first item in the array
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Return the array of items
     *
     * @return DataTransferObject[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function append(DataTransferObject $dto): void
    {
        $this->items[] = $dto;
    }
}
