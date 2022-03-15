<?php

namespace DtoDragon\Test\dtos;

use DtoDragon\DataTransferObject;

class CalendarItemDto extends DataTransferObject
{
    private int $id;

    private string $name;

    private ?ClientDto $client;

    private ?ServiceCollection $services;

    private ?array $tags;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClient(): ClientDto
    {
        return $this->client;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getServices(): ServiceCollection
    {
        return $this->services;
    }
}