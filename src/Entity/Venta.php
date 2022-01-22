<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VentaRepository::class)
 */
class Venta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="ventas")
     */
    private $usuario;

    /**
     * @ORM\OneToOne(targetEntity=estadoventa::class, cascade={"persist", "remove"})
     */
    private $estado;

    /**
     * @ORM\Column(type="object")
     */
    private $articulos;

    

    public function __construct()
    {
        $this->estadoventas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?user
    {
        return $this->usuario;
    }

    public function setUsuario(?user $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getEstado(): ?estadoventa
    {
        return $this->estado;
    }

    public function setEstado(?estadoventa $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getArticulos()
    {
        return $this->articulos;
    }

    public function setArticulos($articulos): self
    {
        $this->articulos = $articulos;

        return $this;
    }

}
