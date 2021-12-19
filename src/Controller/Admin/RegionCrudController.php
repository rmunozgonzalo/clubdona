<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Comuna;
use App\Entity\Admin\Pais;
use App\Entity\Admin\Region;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Region::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setSearchFields(['nombre'])
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(2)
            ->showEntityActionsAsDropdown()
            ->setPageTitle('index', 'Lista de %entity_label_plural%')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id'),
            TextField::new('nombre'),
            AssociationField::new('pais'),
        ];
    }
    
}


