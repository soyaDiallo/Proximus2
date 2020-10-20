<?php

namespace App\Entity;

use App\Repository\OffreProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreProduitRepository::class)
 */
class OffreProduit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statutProximus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statutTingis;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="offreProduits")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="offreProduits")
     */
    private $offre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutProximus(): ?string
    {
        return $this->statutProximus;
    }

    public function setStatutProximus(string $statutProximus): self
    {
        $this->statutProximus = $statutProximus;

        return $this;
    }

    public function getStatutTingis(): ?string
    {
        return $this->statutTingis;
    }

    public function setStatutTingis(string $statutTingis): self
    {
        $this->statutTingis = $statutTingis;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }
}
