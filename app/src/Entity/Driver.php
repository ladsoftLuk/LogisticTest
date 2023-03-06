<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $surname = null;

    #[ORM\OneToOne(mappedBy: 'currentDriver', cascade: ['persist', 'remove'])]
    private ?Vehicle $vehicle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function getFullname(): ?string
    {
        return $this->name . " " . $this->surname;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        // unset the owning side of the relation if necessary
        if ($vehicle === null && $this->vehicle !== null) {
            $this->vehicle->setCurrentDriver(null);
        }

        // set the owning side of the relation if necessary
        if ($vehicle !== null && $vehicle->getCurrentDriver() !== $this) {
            $vehicle->setCurrentDriver($this);
        }

        $this->vehicle = $vehicle;

        return $this;
    }
}
