<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(["MOTOR", "OSOBOWE", "DOSTAWCZE"])]
    
    private string $type;

    #[ORM\Column]

    private int $distance;

    #[ORM\Column(length: 8)]

    private string $registrationNumber;

    #[ORM\Column(nullable: true)]

    private $capacity;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    private ?Driver $currentDriver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDefaultRegistrationNumber(): void
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $type = $this->getType();
        if ($type === 'OSOBOWE' || $type === 'DOSTAWCZE') {
            do {
                $registrationNumber = substr(str_shuffle($chars), 0, 2) . sprintf('%05d', mt_rand(0, 99999));
                $existingVehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy(['registrationNumber' => $registrationNumber]);
            } while ($existingVehicle);
        } else {
            do {
                $registrationNumber = substr(str_shuffle($chars), 0, 2) . sprintf('%02d', mt_rand(0, 99));
                $existingVehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy(['registrationNumber' => $registrationNumber]);
            } while ($existingVehicle);
        }
        $this->setRegistrationNumber($registrationNumber);
    }

    public function getCurrentDriver(): ?Driver
    {
        return $this->currentDriver;
    }

    public function setCurrentDriver(?Driver $currentDriver): self
    {
        $this->currentDriver = $currentDriver;

        return $this;
    }
}
