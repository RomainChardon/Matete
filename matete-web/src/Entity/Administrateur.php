<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idAdmin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=Producteur::class, inversedBy="administrateur", cascade={"persist", "remove"})
     */
    private $Producteur;

    public function getId(): ?int
    {
        return $this->idAdmin;
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

    public function getProducteur(): ?Producteur
    {
        return $this->Producteur;
    }

    public function setProducteur(?Producteur $Producteur): self
    {
        $this->Producteur = $Producteur;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getStatus();
    }
}
