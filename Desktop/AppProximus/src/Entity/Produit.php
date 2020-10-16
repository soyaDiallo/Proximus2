<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="produits")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Remuneration::class, inversedBy="produits")
     */
    private $remuneration;

    /**
     * @ORM\OneToMany(targetEntity=OffreProduit::class, mappedBy="produit")
     */
    private $offreProduits;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->offreProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getRemuneration(): ?Remuneration
    {
        return $this->remuneration;
    }

    public function setRemuneration(?Remuneration $remuneration): self
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    /**
     * @return Collection|OffreProduit[]
     */
    public function getOffreProduits(): Collection
    {
        return $this->offreProduits;
    }

    public function addOffreProduit(OffreProduit $offreProduit): self
    {
        if (!$this->offreProduits->contains($offreProduit)) {
            $this->offreProduits[] = $offreProduit;
            $offreProduit->setProduit($this);
        }

        return $this;
    }

    public function removeOffreProduit(OffreProduit $offreProduit): self
    {
        if ($this->offreProduits->contains($offreProduit)) {
            $this->offreProduits->removeElement($offreProduit);
            // set the owning side to null (unless already changed)
            if ($offreProduit->getProduit() === $this) {
                $offreProduit->setProduit(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->designation;
    }
    
}
