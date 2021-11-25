<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as AppValidator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 * @AppValidator\Usuario()
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={
 *                      "usuario:list"
 *                  }
 *             }
 *         }
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={
 *                      "usuario:item"
 *                   }
 *               }
 *          }
 *     },
 *     order={
 *         "fechaCreacion"="DESC"
 *     },
 *     paginationEnabled=false
 * )
 */
class Usuario implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    const ROLES = [
        'Administrador' => self::ROLE_ADMIN,
        'Usuario' => self::ROLE_USER,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"usuario:list", "usuario:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=false)
     * @Groups({"usuario:list", "usuario:item"})
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $rol;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fecha_actualizacion", type="datetime", nullable=true, options={})
     */
    private $fechaActualizacion = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=false)
     * @Groups({"usuario:list", "usuario:item"})
     */
    private $fechaCreacion;

    /**
     * @var string
     */
    public $plainPassword;

    /**
     * @var string
     */
    public $email;

    public function __construct()
    {
        $this->rol = self::ROLE_USER;
        $this->fechaCreacion  = new \DateTime();
        $this->username = " ";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function GETfULLnAME(): string
    {
      return $this->username;
    }

    public function getEmail(): string
    {
      return $this->username;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {

        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_unique([self::ROLE_USER, $this->rol]);
    }

   public function getRol(): string
   {
       return $this->rol ? $this->rol : self::ROLE_USER;
   }

    public function setRol(string $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion(?\DateTimeInterface $fechaActualizacion): self
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }
}
