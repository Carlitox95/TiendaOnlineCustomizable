<?php

namespace App\Entity;

use App\Repository\ProductosCarritoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductosCarritoRepository::class)
 */
class ProductosCarrito
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class, inversedBy="productosCarritos")
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity=Carrito::class, inversedBy="productoscarrito")
     */
    private $carrito;


    private $monto;

    
    public function __construct()
    {
        $this->productos = new ArrayCollection();
        $this->carrito = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getProducto(): ?producto
    {
        return $this->producto;
    }

    public function setProducto(?producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCarrito(): ?Carrito
    {
        return $this->carrito;
    }

    public function setCarrito(?Carrito $carrito): self
    {
        $this->carrito = $carrito;

        return $this;
    }

    public function getMonto()
    {
        return $this->getProducto()->getPrecio()*$this->getCantidad();
    }

   
   

   
}
