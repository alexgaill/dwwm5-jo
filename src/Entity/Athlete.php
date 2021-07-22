<?php

namespace App\Entity;

use App\Repository\AthleteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AthleteRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Athlete
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut pas contenir de nombre"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prenom ne peut pas contenir de nombre"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")

     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Image
     */
    private $photo;

    /**
     * 
     */
    private $oldPhoto;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="athletes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discipline;

    /**
     *
     * @var Discipline|null
     */
    private $oldDiscipline;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="athletes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pays;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @ORM\PostRemove
     *
     * @return void
     */
    public function removePhoto()
    {
        if (file_exists(__DIR__ . "/../../public/img/profil" . $this->photo)) {
            unlink(__DIR__ . "/../../public/img/profil" . $this->photo);
        }
    }

    /**
     * Get the value of oldDiscipline
     */
    public function getOldDiscipline(): Discipline|null
    {
        return $this->oldDiscipline;
    }

    /**
     * Set the value of oldDiscipline
     */
    public function setOldDiscipline(?Discipline $oldDiscipline): self
    {
        $this->oldDiscipline = $oldDiscipline;

        return $this;
    }

    /**
     * Get the value of oldPhoto
     */
    public function getOldPhoto()
    {
        return $this->oldPhoto;
    }

    /**
     * Set the value of oldPhoto
     */
    public function setOldPhoto($oldPhoto): self
    {
        $this->oldPhoto = $oldPhoto;

        return $this;
    }
}
