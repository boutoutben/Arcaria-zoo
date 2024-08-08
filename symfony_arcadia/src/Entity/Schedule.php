<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $days = null;

    #[ORM\Column(length: 255)]
    private ?string $pm = null;

    #[ORM\Column(length: 255)]
    private ?string $am = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(string $days): static
    {
        $this->days = $days;

        return $this;
    }

    public function getAm(): ?string
    {
        return $this->am;
    }

    public function setAm(string $am): static
    {
        $this->am = $am;

        return $this;
    }

    public function getPm(): ?string
    {
        return $this->pm;
    }

    public function setPm(string $pm): static
    {
        $this->pm = $pm;

        return $this;
    }
}
