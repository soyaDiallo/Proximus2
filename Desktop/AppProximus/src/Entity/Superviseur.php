<?php

namespace App\Entity;

use App\Repository\SuperviseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuperviseurRepository::class)
 */
class Superviseur extends User
{
    /**
     * @ORM\Id() ORM\@OneToOne(targetEntity="User")
     * ORM\JoinColumn(name="id", referencedColumnName="id")
     **/
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
