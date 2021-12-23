<?php

namespace App\Entity\Contacto;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Admin\Comuna;
use App\Repository\Contacto\ClienteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 */
class Cliente
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
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Comuna")
     * @ORM\JoinColumn(nullable=true)
     */
    private $comuna;

    /**
     * @ORM\Column(type="bigint")
     */
    private $puntos=0;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="nacimiento", type="datetime", nullable=true)
     */
    private $fechaNacimiento = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion = NULL;

    public function __construct()
    {
        $this->fechaCreacion =  new \Datetime('now');
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getRut(): ?string
    {
        return $this->rut;
    }

    public function setRut(?string $rut): self
    {
        $this->rut = $rut;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getPuntos(): ?string
    {
        return $this->puntos;
    }

    public function setPuntos(string $puntos): self
    {
        $this->puntos = $puntos;

        return $this;
    }

    public function getComuna(): ?Comuna
    {
        return $this->comuna;
    }

    public function setComuna(?Comuna $comuna): self
    {
        $this->comuna = $comuna;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getNombreCompleto(): ?string
    {
        return $this->nombre.' '.$this->apellidos;
    }

    public function toArray()
    {
        return [$this->nombre,$this->apellidos,$this->email];
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

}
