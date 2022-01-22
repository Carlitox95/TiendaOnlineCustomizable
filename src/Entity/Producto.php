<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 */
class Producto
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
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity=Categoria::class, mappedBy="producto")
     */
    private $categorias;
   
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Precio;

    /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     */
    private $descripcionCompleta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $destacado;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity=ProductosCarrito::class, mappedBy="producto")
     */
    private $productosCarritos;

    /**
     * @ORM\OneToMany(targetEntity=Imagen::class, mappedBy="producto")
     */
    private $imagens;

    
    public function __construct()
    {
        $this->categorias = new ArrayCollection();
        $this->imagenes = new ArrayCollection();
        $this->carrito = new ArrayCollection();
        $this->productosCarritos = new ArrayCollection();
        $this->imagens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
     $this->descripcion = $descripcion;
     return $this;
    }


    function setCategorias($categorias) {
     $this->categorias = $categorias;
     return $this;
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(Categoria $categoria): self
    {
        if (!$this->categorias->contains($categoria)) {
            $this->categorias[] = $categoria;
            $categoria->addProducto($this);
        }

        return $this;
    }

    public function removeCategoria(Categoria $categoria): self
    {
        if ($this->categorias->removeElement($categoria)) {
            $categoria->removeProducto($this);
        }

        return $this;
    }

    /**
     * @return Collection|Imagen[]
     */
    public function getImagens(): Collection
    {
        return $this->imagens;
    }

    public function addImagen(Imagen $imagen): self
    {
        if (!$this->imagens->contains($imagen)) {
            $this->imagens[] = $imagen;
            $imagen->setProducto($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): self
    {
        if ($this->imagens->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getProducto() === $this) {
                $imagen->setProducto(null);
            }
        }

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->Precio;
    }

    public function setPrecio(?float $Precio): self
    {
        $this->Precio = $Precio;

        return $this;
    }

    public function getDescripcionCompleta(): ?string
    {
        return $this->descripcionCompleta;
    }

    public function setDescripcionCompleta(?string $descripcionCompleta): self
    {
        $this->descripcionCompleta = $descripcionCompleta;

        return $this;
    }

    public function getDestacado(): ?bool
    {
        return $this->destacado;
    }

    public function setDestacado(?bool $destacado): self
    {
        $this->destacado = $destacado;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|ProductosCarrito[]
     */
    public function getProductosCarritos(): Collection
    {
        return $this->productosCarritos;
    }

    public function addProductosCarrito(ProductosCarrito $productosCarrito): self
    {
        if (!$this->productosCarritos->contains($productosCarrito)) {
            $this->productosCarritos[] = $productosCarrito;
            $productosCarrito->setProducto($this);
        }

        return $this;
    }

    public function removeProductosCarrito(ProductosCarrito $productosCarrito): self
    {
        if ($this->productosCarritos->removeElement($productosCarrito)) {
            // set the owning side to null (unless already changed)
            if ($productosCarrito->getProducto() === $this) {
                $productosCarrito->setProducto(null);
            }
        }

        return $this;
    }

    

  
}
