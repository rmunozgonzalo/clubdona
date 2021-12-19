<?php

namespace App\Controller\Contacto;

use App\Entity\Contacto\Cliente;
use App\Entity\Admin\Comuna;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Fields\ComunaClienteField;

class ClienteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cliente::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setSearchFields(['nombre', 'email'])
            ->setPaginatorPageSize(50)
            ->setPaginatorRangeSize(2)
            ->showEntityActionsAsDropdown()
            ->setPageTitle('index', 'Lista de %entity_label_plural%')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            TextField::new('apellidos'),
            TextField::new('rut'),
            TextField::new('email'),
            TextField::new('telefono'),
            TextField::new('facebook'),
            TextField::new('twitter'),
            TextField::new('instagram'),
            TextField::new('direccion'),
            TextField::new('puntos'),
            AssociationField::new('comuna', 'Comuna')
            //AssociationField::new('comuna')->setCrudController(\App\Controller\Admin\ComunaCrudController::class),
            //AssociationField::new('comuna')->autocomplete(),
            //ComunaClienteField::new('comuna', 'Comuna')
            //->setFormTypeOptions([
            //]),
        ];
    }
}
