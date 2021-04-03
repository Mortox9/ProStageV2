<?php

namespace App\Entity;

use App\Entity\Formation;
use App\Repository\StageRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;  //Identifiant généré automatiquement

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $intitule;  //Intitulé du Stage

    /**
     * @ORM\Column(type="string", length=480)
     */
    private $description; //Description du Stage

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut; //Date de commencement du Stage

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $duree; //Durée totale du Stage

    /**
     * @ORM\Column(type="string", length=288)
     */
    private $competencesRequises; //Compétences exigées pour postuler au Stage

    /**
     * @ORM\Column(type="string", length=288)
     */
    private $experienceRequise; //Expérience exigée pour postuler au Stage

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Formation; //Formation à laquelle le Stage est destiné

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;  //Entreprise qui propose le Stage

    public function __construct()
    {
      $this->Formation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCompetencesRequises(): ?string
    {
        return $this->competencesRequises;
    }

    public function setCompetencesRequises(string $competencesRequises): self
    {
        $this->competencesRequises = $competencesRequises;

        return $this;
    }

    public function getExperienceRequise(): ?string
    {
        return $this->experienceRequise;
    }

    public function setExperienceRequise(string $experienceRequise): self
    {
        $this->experienceRequise = $experienceRequise;

        return $this;
    }

    public function getFormation(): Collection
    {
        return $this->Formation;
    }

    public function setFormation(?Formation $Formation): self
    {
        $this->Formation = $Formation;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
