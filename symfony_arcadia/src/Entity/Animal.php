<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Races;
use DateTime;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Validator\Constraints\Date;

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
    private ?Races $Race = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column]
    private ?DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $nourriture = null;

    #[ORM\Column]
    private ?int $quantitee = null;

    #[ORM\OneToOne(targetEntity:'RapportVeterinaire')]
    #[ORM\JoinColumn(name:'id_last_rapport',referencedColumnName:'id')]
    private ?RapportVeterinaire $LastRapport = null;

    #[ORM\Column]
    private ?int $nbClick = null;


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
        return $this->Race;
    }

    public function setRace(Races $race): self
    {
        $this->Race = $race;

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

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->nourriture;
    }

    public function setNourriture(string $nourriture): static
    {
        $this->nourriture = $nourriture;
        return $this;
    }

    public function getQuantitee(): ?String
    {
        return $this->quantitee;
    }

    public function setQuantitee(string $Quantitee): static
    {
        $this->quantitee = $Quantitee;
        return $this;
    }

    public function getLastRapport(): ?RapportVeterinaire
    {
        return $this->LastRapport;
    }

    public function setLastRapport(RapportVeterinaire $lastRapport): self
    {
        $this->LastRapport = $lastRapport;
        return $this;
    }

    public function getNbClick(): ?int
    {
        return $this->nbClick;
    }

    public function setNbClick(int $nbClick): static
    {
        $this->nbClick = $nbClick;
        return $this;
    }

}

