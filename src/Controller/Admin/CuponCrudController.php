<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Cupon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CuponCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cupon::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $cupon = new Cupon();
        $cupon->setRegistradoPor($this->getUser());
        $cupon->setIsActive(true);
        return $cupon;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            TextField::new('codigo'),
            DateTimeField::new('fechaRegistro')->setFormTypeOption('disabled','disabled'),
            DateTimeField::new('fechaVencimiento'),
            TextField::new('estado'),
            BooleanField::new('isActive'),
            TextField::new('token'),
            AssociationField::new('registradoPor')->hideOnForm(),
        ];
    }
    
}
