<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\Column(type="datetime")
     */
    private $dateInsertion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTVA;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreationSTE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numClientProximus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTelephoneFixe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numGSM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numIBAN;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numPorte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseInstallation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInstallation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $infoEncodage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTelephoneProximus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numClientConcurrence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numEasySwitch;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numCarteSIMPrepayee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomClientMobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeClientMobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appMobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bonusTV;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienDrivePartageable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carteIdentite;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="clients")
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="client")
     */
    private $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
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

    public function getDateInsertion(): ?\DateTimeInterface
    {
        return $this->dateInsertion;
    }

    public function setDateInsertion(\DateTimeInterface $dateInsertion): self
    {
        $this->dateInsertion = $dateInsertion;

        return $this;
    }

    public function getTypeClient(): ?string
    {
        return $this->typeClient;
    }

    public function setTypeClient(string $typeClient): self
    {
        $this->typeClient = $typeClient;

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

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getNumTVA(): ?string
    {
        return $this->numTVA;
    }

    public function setNumTVA(string $numTVA): self
    {
        $this->numTVA = $numTVA;

        return $this;
    }

    public function getDateCreationSTE(): ?\DateTimeInterface
    {
        return $this->dateCreationSTE;
    }

    public function setDateCreationSTE(\DateTimeInterface $dateCreationSTE): self
    {
        $this->dateCreationSTE = $dateCreationSTE;

        return $this;
    }

    public function getNumClientProximus(): ?string
    {
        return $this->numClientProximus;
    }

    public function setNumClientProximus(string $numClientProximus): self
    {
        $this->numClientProximus = $numClientProximus;

        return $this;
    }

    public function getNumTelephoneFixe(): ?string
    {
        return $this->numTelephoneFixe;
    }

    public function setNumTelephoneFixe(string $numTelephoneFixe): self
    {
        $this->numTelephoneFixe = $numTelephoneFixe;

        return $this;
    }

    public function getNumGSM(): ?string
    {
        return $this->numGSM;
    }

    public function setNumGSM(string $numGSM): self
    {
        $this->numGSM = $numGSM;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumIBAN(): ?string
    {
        return $this->numIBAN;
    }

    public function setNumIBAN(string $numIBAN): self
    {
        $this->numIBAN = $numIBAN;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumPorte(): ?int
    {
        return $this->numPorte;
    }

    public function setNumPorte(int $numPorte): self
    {
        $this->numPorte = $numPorte;

        return $this;
    }

    public function getAdresseInstallation(): ?string
    {
        return $this->adresseInstallation;
    }

    public function setAdresseInstallation(string $adresseInstallation): self
    {
        $this->adresseInstallation = $adresseInstallation;

        return $this;
    }

    public function getDateInstallation(): ?\DateTimeInterface
    {
        return $this->dateInstallation;
    }

    public function setDateInstallation(\DateTimeInterface $dateInstallation): self
    {
        $this->dateInstallation = $dateInstallation;

        return $this;
    }

    public function getInfoEncodage(): ?string
    {
        return $this->infoEncodage;
    }

    public function setInfoEncodage(string $infoEncodage): self
    {
        $this->infoEncodage = $infoEncodage;

        return $this;
    }

    public function getNumTelephoneProximus(): ?string
    {
        return $this->numTelephoneProximus;
    }

    public function setNumTelephoneProximus(string $numTelephoneProximus): self
    {
        $this->numTelephoneProximus = $numTelephoneProximus;

        return $this;
    }

    public function getNumClientConcurrence(): ?string
    {
        return $this->numClientConcurrence;
    }

    public function setNumClientConcurrence(string $numClientConcurrence): self
    {
        $this->numClientConcurrence = $numClientConcurrence;

        return $this;
    }

    public function getNumEasySwitch(): ?string
    {
        return $this->numEasySwitch;
    }

    public function setNumEasySwitch(string $numEasySwitch): self
    {
        $this->numEasySwitch = $numEasySwitch;

        return $this;
    }

    public function getNumCarteSIMPrepayee(): ?string
    {
        return $this->numCarteSIMPrepayee;
    }

    public function setNumCarteSIMPrepayee(string $numCarteSIMPrepayee): self
    {
        $this->numCarteSIMPrepayee = $numCarteSIMPrepayee;

        return $this;
    }

    public function getNomClientMobile(): ?string
    {
        return $this->nomClientMobile;
    }

    public function setNomClientMobile(string $nomClientMobile): self
    {
        $this->nomClientMobile = $nomClientMobile;

        return $this;
    }

    public function getCodeClientMobile(): ?string
    {
        return $this->codeClientMobile;
    }

    public function setCodeClientMobile(string $codeClientMobile): self
    {
        $this->codeClientMobile = $codeClientMobile;

        return $this;
    }

    public function getAppMobile(): ?string
    {
        return $this->appMobile;
    }

    public function setAppMobile(string $appMobile): self
    {
        $this->appMobile = $appMobile;

        return $this;
    }

    public function getBonusTV(): ?string
    {
        return $this->bonusTV;
    }

    public function setBonusTV(string $bonusTV): self
    {
        $this->bonusTV = $bonusTV;

        return $this;
    }

    public function getLienDrivePartageable(): ?string
    {
        return $this->lienDrivePartageable;
    }

    public function setLienDrivePartageable(string $lienDrivePartageable): self
    {
        $this->lienDrivePartageable = $lienDrivePartageable;

        return $this;
    }

    public function getCarteIdentite(): ?string
    {
        return $this->carteIdentite;
    }

    public function setCarteIdentite(string $carteIdentite): self
    {
        $this->carteIdentite = $carteIdentite;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setClient($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->contains($offre)) {
            $this->offres->removeElement($offre);
            // set the owning side to null (unless already changed)
            if ($offre->getClient() === $this) {
                $offre->setClient(null);
            }
        }

        return $this;
    }
}
