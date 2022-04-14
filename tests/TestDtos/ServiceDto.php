<?php

namespace DtoDragon\Test\TestDtos;

use DtoDragon\DataTransferObject;

class ServiceDto extends DataTransferObject
{
    private int $id;

    private string $type;

    private ?float $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ServiceDto
     */
    public function setId(int $id): ServiceDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ServiceDto
     */
    public function setType(string $type): ServiceDto
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     *
     * @return ServiceDto
     */
    public function setPrice(?float $price): ServiceDto
    {
        $this->price = $price;
        return $this;
    }
}