<?php

namespace App\Entity;

use App\Repository\SaldosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaldosRepository::class)
 */
class Saldos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $monto;

    /**
     * @ORM\OneToOne(targetEntity=Personas::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $persona;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(float $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getPersona(): ?Personas
    {
        return $this->persona;
    }

    public function setPersona(Personas $persona): self
    {
        $this->persona = $persona;

        return $this;
    }
}
