<?php

namespace App\Controller\Contacto;

use App\Entity\Contacto\Cliente;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClienteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cliente::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
