<?php

namespace App\Entity;

use App\Repository\OperacionesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperacionesRepository::class)
 */
class Operaciones
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
     * @ORM\Column(type="string", length=20)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity=Personas::class)
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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getPersona(): ?Personas
    {
        return $this->persona;
    }

    public function setPersona(?Personas $persona): self
    {
        $this->persona = $persona;

        return $this;
    }
}
