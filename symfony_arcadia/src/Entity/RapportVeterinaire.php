<?php

namespace App\Entity;

use App\Repository\RapportVeterinaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;
use DateTime;

#[ORM\Entity(repositoryClass: RapportVeterinaireRepository::class)]
class RapportVeterinaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $detail = null;

    #[ORM\OneToOne(targetEntity:'Animal')]
    #[ORM\JoinColumn(name:'id_animal',referencedColumnName:'id')]
    private ?Animal $Animal = null;

    public function __construct() {
        /*$this->_csrf_token= bin2hex(random_bytes(28));*/
        $this->Date = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->Date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->Date = $date;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->Animal;
    }

    public function setAnimal(Animal $animal): static
    {
        $this->Animal = $animal;

        return $this;
    }
}
