<?php

namespace App\Controller\Admin;

use App\Entity\Admin\ParametroConfiguracion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ParametroConfiguracionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ParametroConfiguracion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['parametro' => 'ASC'])
            ->setEntityLabelInPlural('Parámetros')
            ->setEntityLabelInSingular('Parámetro')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('parametro')
                ->setLabel('ID del parámetro')
                ->hideWhenUpdating(),
            ChoiceField::new('formType')
                 ->setLabel('Tipo de valor')
                 ->setChoices([
                     'Número Entero' => \Symfony\Component\Form\Extension\Core\Type\IntegerType::class,
                     'Selección' => \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
                     'Verdadero o Falso' => \Symfony\Component\Form\Extension\Core\Type\BooleanType::class
                 ])
                 ->onlyWhenCreating(),
            TextField::new('descripcion')
                ->setLabel('Descripción'),
            Field::new('valor')
                ->setLabel('Valor'),
        ];
    }
}

