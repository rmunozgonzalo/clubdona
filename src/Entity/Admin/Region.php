<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\RegionRepository")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Admin\Comuna", mappedBy="region")
     */
    private $comunas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Pais")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pais;

    public function __construct()
    {
        $this->comunas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNombre(): ?string
    {
        return strtoupper($this->nombre);
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = strtoupper($nombre);

        return $this;
    }

    /** 
     * @return Collection|Comuna[]
     */
    public function getComunas(): Collection
    {
        return $this->comunas;
    }

    public function addComuna(Comuna $comuna): self
    {
        if (!$this->comunas->contains($comuna)) {
            $this->comunas[] = $comuna;
            $comuna->setRegion($this);
        }

        return $this;
    }

    public function removeComuna(Comuna $comuna): self
    {
        if ($this->comunas->contains($comuna)) {
            $this->comunas->removeElement($comuna);
            // set the owning side to null (unless already changed)
            if ($comuna->getRegion() === $this) {
                $comuna->setRegion(null);
            }
        }

        return $this;
    }

    function __toString(){
        return $this->nombre;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}
