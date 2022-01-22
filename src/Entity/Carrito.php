<?php

namespace App\Entity;

use App\Repository\CarritoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarritoRepository::class)
 */
class Carrito
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
    private $Monto;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="carrito", cascade={"persist", "remove"})
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity=productoscarrito::class, mappedBy="carrito")
     */
    private $productoscarrito;
  

    public function __construct()
    {
        $this->productos = new ArrayCollection();
        $this->productosCarritos = new ArrayCollection();
        $this->productoscarrito = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?float
    {
        return $this->Monto;
    }

    public function setMonto(float $Monto): self
    {
        $this->Monto = $Monto;

        return $this;
    }

    
    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection|productoscarrito[]
     */
    public function getProductoscarrito(): Collection
    {
        return $this->productoscarrito;
    }

    public function addProductoscarrito(productoscarrito $productoscarrito): self
    {
        if (!$this->productoscarrito->contains($productoscarrito)) {
            $this->productoscarrito[] = $productoscarrito;
            $productoscarrito->setCarrito($this);
        }

        return $this;
    }

    public function removeProductoscarrito(productoscarrito $productoscarrito): self
    {
        if ($this->productoscarrito->removeElement($productoscarrito)) {
            // set the owning side to null (unless already changed)
            if ($productoscarrito->getCarrito() === $this) {
                $productoscarrito->setCarrito(null);
            }
        }
        return $this;
    }

    public function getMontoTotal() {
     //Defino el Monto en 0
     $montoTotal=0;
        //Iteramos sobre todos los productos para saber el total por producto
        foreach ($this->getProductoscarrito() as $productoCarrito) {
         $montoProducto=($productoCarrito->getProducto()->getPrecio() * $productoCarrito->getCantidad());
         $montoTotal=$montoTotal + $montoProducto;            
        }    

     //Retorno el valor total
     return $montoTotal;
    }
    

}
