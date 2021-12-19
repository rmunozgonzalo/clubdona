<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass=\App\Repository\Admin\ParametroConfiguracionRepository::class)
 */
class ParametroConfiguracion
{

    const VALOR  = 'VALOR';

    const defaultConfig = [
        self::VALOR => [
            "descripcion" => "El valor que se agregará a los puntos de un registro.",
            'formType' => IntegerType::class,
            'valor' => 1000
        ],
    ];

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $parametro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $formType;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->formType == IntegerType::class && $this->valor <= 0) {
            $context->buildViolation('El valor debe ser mayor a 0.')
                ->atPath('valor')
                ->addViolation();
        }
    }

    public function getParametro(): ?string
    {
        return $this->parametro;
    }

    public function setParametro(string $parametro): self
    {
        $this->parametro = strtoupper($parametro);

        return $this;
    }

    public function getConfig(): ?self
    {
        return $this;
    }

    public function setConfig($value): ?self
    {
        return $this->valor = $value;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

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

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function setFormType(string $formType): self
    {
        $this->formType = $formType;

        return $this;
    }

    public function __toString(){
        return $this->parametro;
    }
}

