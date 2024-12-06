<?php
namespace App\Model;
class Location{
    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $address
     * @param int|null $capacity
     */


    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private string $address,
        private ?int $capacity = null

    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }





}

