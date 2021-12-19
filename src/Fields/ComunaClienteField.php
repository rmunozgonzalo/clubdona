<?php

namespace App\Fields;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use App\Form\ClienteComunaFormType;

final class ComunaClienteField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = 'Comuna'): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormTypeOption('by_reference', false)
            ->setFormType(ClienteComunaFormType::class)
        ;
    }
}
