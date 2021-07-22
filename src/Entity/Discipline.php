<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 * @UniqueEntity("nom")
 */
class Discipline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $nombreCandidats;

    /**
     * @ORM\OneToMany(targetEntity=Athlete::class, mappedBy="discipline", orphanRemoval=true)
     */
    private $athletes;

    public function __construct()
    {
        $this->athletes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNombreCandidats(): ?int
    {
        return $this->nombreCandidats;
    }

    public function setNombreCandidats(int $nombreCandidats): self
    {
        $this->nombreCandidats = $nombreCandidats;

        return $this;
    }

    /**
     * @return Collection|Athlete[]
     */
    public function getAthletes(): Collection
    {
        return $this->athletes;
    }

    public function addAthlete(Athlete $athlete): self
    {
        if (!$this->athletes->contains($athlete)) {
            $this->athletes[] = $athlete;
            $athlete->setDiscipline($this);
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        if ($this->athletes->removeElement($athlete)) {
            // set the owning side to null (unless already changed)
            if ($athlete->getDiscipline() === $this) {
                $athlete->setDiscipline(null);
            }
        }

        return $this;
    }
}
