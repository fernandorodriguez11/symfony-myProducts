<?php

namespace App\Entity;

use App\Repository\ProductosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductosRepository::class)
 */
class Productos
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
    private $foto_producto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tienda;

    /**
     * @ORM\Column(name="ubicacion", type="string", columnDefinition="enum('cocina','baño','casa')")
     */
    private $ubicacion_casa;

    /**
     * @ORM\Column(name="tipo", type="string", columnDefinition="enum('alimentacion','limpieza')")
     */
    private $tipo_producto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cesta", mappedBy="producto")
     */
    private $cesta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFotoProducto(): ?string
    {
        return $this->foto_producto;
    }

    public function setFotoProducto(string $foto_producto): self
    {
        $this->foto_producto = $foto_producto;

        return $this;
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

    public function getTienda(): ?string
    {
        return $this->tienda;
    }

    public function setTienda(string $tienda): self
    {
        $this->tienda = $tienda;

        return $this;
    }

    public function getUbicacionCasa(): ?string
    {
        return $this->ubicacion_casa;
    }

    public function setUbicacionCasa(string $ubicacion_casa): self
    {
        $this->ubicacion_casa = $ubicacion_casa;

        return $this;
    }

    public function getTipoProducto(): ?string
    {
        return $this->tipo_producto;
    }

    public function setTipoProducto(string $tipo_producto): self
    {
        $this->tipo_producto = $tipo_producto;

        return $this;
    }
}
