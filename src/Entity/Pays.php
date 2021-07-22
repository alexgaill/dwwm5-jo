<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 * @UniqueEntity("nom")
 * @ORM\HasLifecycleCallbacks()
 */
class Pays
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="LE nom du pays ne peut pas contenir de nombre"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Image
     */
    private $drapeau;

    /**
     * @ORM\OneToMany(targetEntity=Athlete::class, mappedBy="pays", orphanRemoval=true)
     */
    private $athletes;

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

    public function getDrapeau()
    {
        return $this->drapeau;
    }

    public function setDrapeau($drapeau): self
    {
        $this->drapeau = $drapeau;

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
            $athlete->setPays($this);
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        if ($this->athletes->removeElement($athlete)) {
            // set the owning side to null (unless already changed)
            if ($athlete->getPays() === $this) {
                $athlete->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PostRemove
     *
     * @return bool
     */
    public function deleteDrapeau()
    {
        if (file_exists(__DIR__ ."/../../public/img/drapeaux/".$this->drapeau)) {
            unlink(__DIR__ ."/../../public/img/drapeaux/".$this->drapeau);
        }
        return true;
    }
}
