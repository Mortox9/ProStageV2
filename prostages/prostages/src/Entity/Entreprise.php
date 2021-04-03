<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;  //Identifiant de l'Entreprise généré automatiquement

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Le nom de l'entreprise doit faire au moins {{ limit }} caractères."
     * )
     */
    private $nom; //Nom de l'Entreprise

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Regex(pattern="/^\b[1-9]{1}[0-9]{0,3}\b/",
     *               message="Le numéro de la rue semble incorrect")
     * @Assert\Regex(pattern="/(allée|avenue|rue|boulevard|impasse|cours|passage|route)/",
     *               message="Le type de route/voie semble incorrect")
     * @Assert\Regex(pattern="/\b((0[1-9])|([1-8][0-9])|(9[0-8]))[0-9]{3}\b/",
     *               message="Il semble y avoir un problème avec le code postal")
     */
    private $adresse; //Adresse de l'Entreprise

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(
     *    message = "Cette valeur ne doit pas être vide."
     *)
     */
    private $milieu;  //Milieu de l'Entreprise

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $telephone; //Téléphone de l'Entreprise

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Url(
     *    message = "Cette valeur n'est pas une URL valide."
     * )
     */
    private $photo; //Url de la photo de l'Entreprise

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;  //Liste des Stages liés à cette Entreprise

    public function __construct()
    {
        $this->stages = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMilieu(): ?string
    {
        return $this->milieu;
    }

    public function setMilieu(string $milieu): self
    {
        $this->milieu = $milieu;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
