<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idAnnonce;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $creneauxDebut;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $creneauxFin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelleProduit;

    /**
     * @ORM\Column(type="float")
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="Annonce", cascade={"persist"})
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="Annonce")
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity=Commande::class, mappedBy="Annonce")
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity=Producteur::class, inversedBy="Annonce")
     */
    private $producteur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateMiseEnLigne;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idAnnonce;
    }

    public function getCreneauxDebut(): ?\DateTimeImmutable
    {
        return $this->creneauxDebut;
    }

    public function setCreneauxDebut(\DateTimeImmutable $creneauxDebut): self
    {
        $this->creneauxDebut = $creneauxDebut;

        return $this;
    }

    public function getCreneauxFin(): ?\DateTimeImmutable
    {
        return $this->creneauxFin;
    }

    public function setCreneauxFin(\DateTimeImmutable $creneauxFin): self
    {
        $this->creneauxFin = $creneauxFin;

        return $this;
    }

    public function getLibelleProduit(): ?string
    {
        return $this->libelleProduit;
    }

    public function setLibelleProduit(string $libelleProduit): self
    {
        $this->libelleProduit = $libelleProduit;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addAnnonce($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeAnnonce($this);
        }

        return $this;
    }

    public function getProducteur(): ?Producteur
    {
        return $this->producteur;
    }

    public function setProducteur(?Producteur $producteur): self
    {
        $this->producteur = $producteur;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateMiseEnLigne(): ?\DateTimeInterface
    {
        return $this->dateMiseEnLigne;
    }

    public function setDateMiseEnLigne(?\DateTimeInterface $dateMiseEnLigne): self
    {
        $this->dateMiseEnLigne = $dateMiseEnLigne;

        return $this;
    }
}
