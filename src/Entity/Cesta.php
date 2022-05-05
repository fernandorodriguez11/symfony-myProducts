<?php

namespace App\Entity;

use App\Repository\CestaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CestaRepository::class)
 */
class Cesta
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
     * @ORM\Column(type="boolean")
     */
    private $comprado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cesta")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Productos", inversedBy="cesta")
     */
    private $producto;

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

    public function getComprado(): ?bool
    {
        return $this->comprado;
    }

    public function setComprado(bool $comprado): self
    {
        $this->comprado = $comprado;

        return $this;
    }

    public function getUser(){
        return $this->user;
    }

    public function setUser($user){
        $this->user = $user;
    }

    public function getProducto(){
        return $this->producto;
    }

    public function setProducto($producto){
        $this->producto = $producto;
    }
}
