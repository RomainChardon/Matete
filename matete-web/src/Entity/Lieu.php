<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
* @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idLieu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cooX;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cooY;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descLieu;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="lieu")
     */
    private $Annonce;

    /**
     * @ORM\ManyToMany(targetEntity=Producteur::class, inversedBy="lieux")
     */
    private $Producteur;

    public function __construct()
    {
        $this->Annonce = new ArrayCollection();
        $this->Producteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idLieu;
    }

    public function getCooX(): ?string
    {
        return $this->cooX;
    }

    public function setCooX(string $cooX): self
    {
        $this->cooX = $cooX;

        return $this;
    }

    public function getCooY(): ?string
    {
        return $this->cooY;
    }

    public function setCooY(string $cooY): self
    {
        $this->cooY = $cooY;

        return $this;
    }

    public function getDescLieu(): ?string
    {
        return $this->descLieu;
    }

    public function setDescLieu(?string $descLieu): self
    {
        $this->descLieu = $descLieu;

        return $this;
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

    public function __toString(): string
    {
        return $this->getNom();
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonce(): Collection
    {
        return $this->Annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->Annonce->contains($annonce)) {
            $this->Annonce[] = $annonce;
            $annonce->setLieu($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->Annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getLieu() === $this) {
                $annonce->setLieu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Producteur[]
     */
    public function getProducteur(): Collection
    {
        return $this->Producteur;
    }

    public function addProducteur(Producteur $producteur): self
    {
        if (!$this->Producteur->contains($producteur)) {
            $this->Producteur[] = $producteur;
        }

        return $this;
    }

    public function removeProducteur(Producteur $producteur): self
    {
        $this->Producteur->removeElement($producteur);

        return $this;
    }
}
