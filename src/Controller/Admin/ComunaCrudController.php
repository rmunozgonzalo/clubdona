<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Comuna;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ComunaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comuna::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('id'),
            TextField::new('nombre'),
        ];
    }
    
}

