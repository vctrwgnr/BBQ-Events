<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Should not be blank')]
    #[Assert\Length(min: 3,
        max: 255,
        minMessage: 'too short',
        maxMessage: 'too long')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $bookedSeats = null;

    #[ORM\Column(type: 'integer')]
    private int $likes = 0;

    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBookedSeats(): ?int
    {
        return $this->bookedSeats;
    }

    public function setBookedSeats(int $bookedSeats): static
    {
        $this->bookedSeats = $bookedSeats;

        return $this;
    }

    public function seats(): int{
        return $this->location->getCapacity() - $this->bookedSeats;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;
        return $this;
    }

    public function incrementLikes(): self
    {
        $this->likes++;
        return $this;
    }
}
