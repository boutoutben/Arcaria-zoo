<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Races;
use PhpParser\Node\Expr\Cast\String_;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;


   
    #[ORM\OneToOne(targetEntity:'AllHabitats')]
    #[ORM\JoinColumn(name:'id_habitat',referencedColumnName:'id')]
    private ?AllHabitats $Habitats = null;

    #[ORM\OneToOne(targetEntity:'Races')]
    #[ORM\JoinColumn(name:'id_race',referencedColumnName:'id')]
    private ?Races $race = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;


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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getHabitats(): ?AllHabitats
    {
        return $this->Habitats;
    }

    public function setHabitats(AllHabitats $Habitats): self
    {
        $this->Habitats = $Habitats;
        return $this;
    }

    public function getRaces():?Races
    {
        return $this->race;
    }

    public function setRace(Races $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getImg(): ?String
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;
        return $this;
    }

}

