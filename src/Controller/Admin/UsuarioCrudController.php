<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UsuarioCrudController extends AbstractCrudController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getEntityFqcn(): string
    {
        return Usuario::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('rol')
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->setChoices(Usuario::ROLES)
            ,
            TextField::new('username', 'Nombre de Usuario')
            ,
            TextField::new('plainPassword', 'Contraseña')
                ->hideOnIndex()
                ->hideOnDetail()
                ->setValue('')
            ,
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword($this->passwordEncoder->encodePassword($entityInstance, $entityInstance->plainPassword));
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword($this->passwordEncoder->encodePassword($entityInstance, $entityInstance->plainPassword));
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
