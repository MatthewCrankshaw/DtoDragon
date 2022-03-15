<?php

namespace DtoDragon;

use Iterator;

abstract class DataTransferObjectCollection implements Iterator
{
    private int $position;

    /**
     * @var DataTransferObject[]
     */
    private array $items = [];

    public function __construct(array $items)
    {
        $this->position = 0;
        $this->validate($items);
        $this->items = $items;
    }

    private function validate(array $array): bool
    {
        foreach ($array as $key => $item) {
            if (!is_a($item, DataTransferObject::class)) {
                throw new \Exception('Each item in the collection must be a child class of ' . DataTransferObject::class);
            }
        }
        return true;
    }

    abstract public static function dtoType(): string;

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->items[$this->position];
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->items as $item) {
            $array[] = $item->toArray();
        }
        return $array;
    }
}