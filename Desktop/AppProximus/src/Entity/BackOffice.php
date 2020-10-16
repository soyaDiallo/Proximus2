<?php

namespace App\Entity;

use App\Repository\BackOfficeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BackOfficeRepository::class)
 */
class BackOffice extends User
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
