<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use App\Entity\Contacto\Cliente;
use App\Entity\Admin\Cupon;


use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {

        return $this->render('bundles/EasyAdminBundle/page/content.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BASE')
            ->setTranslationDomain('admin')
            ->disableUrlSignatures();
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setSearchFields(['nombre', 'codigo'])
            ->setPaginatorPageSize(50)
            ->setPaginatorRangeSize(2)
            ->showEntityActionsAsDropdown()
            ->setPageTitle('index', 'Lista de %entity_label_plural%')
            ->setHelp('edit', '..ssdsds.')
        ;
    }

    public function configureActions(): Actions
    {

        return Actions::new()
        ->add(Crud::PAGE_INDEX, Action::NEW)
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setIcon('fa fa-plus-square')->setLabel('Agregar');
        })
        ->add(Crud::PAGE_INDEX, Action::EDIT)
        ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->setIcon('fa fa-edit')->setLabel('Actualizar');
        })
        ->add(Crud::PAGE_INDEX, Action::DELETE)
        ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            return $action->setIcon('fa fa-trash')->setLabel('Eliminar/Suspender');
        })
        ->add(Crud::PAGE_INDEX,Action::DETAIL)
        ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->setLabel('Ver');
        })

        ->add(Crud::PAGE_DETAIL, Action::EDIT)
        ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
            return $action->setIcon('fa fa-edit')->setLabel('Actualizar');
        })

        ->add(Crud::PAGE_DETAIL, Action::INDEX)
        ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
            return $action->setIcon('fa fa-caret-square-left')->setLabel('Volver');
        })
        ->add(Crud::PAGE_DETAIL, Action::DELETE)
        ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
            return $action->setIcon('fa fa-trash')->setLabel('Eliminar/Suspender');
        })


        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
            return $action->setIcon('fa fa-save')->setLabel('Guardar');
        })
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
            return $action->setIcon('fa fa-save')->setLabel('Guardar y Continuar');
        })
        ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->update(Crud::PAGE_EDIT, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-caret-square-left')->setLabel('Volver');
            })

        //Actions in PAGE_NEW
        ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
            return $action->setIcon('fa fa-save')->setLabel('Guardar');
        })
        ->add(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
            return $action->setIcon('fa fa-save')->setLabel('Guardar y Continuar con Otro');
        })
        ->add(Crud::PAGE_NEW, Action::INDEX)
        ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
            return $action->setIcon('fa fa-caret-square-left')->setLabel('Volver');
        })
        ;
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToRoute('Mi perfil', 'fa fa-id-card', 'perfil'),
                MenuItem::section(),
            ]);
    }

    public function configureMenuItems(): iterable 
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        return [

            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Contacto'),
            MenuItem::linkToCrud('Clientes', 'fa fa-customer', Cliente::class),
            MenuItem::section('Administración',''),
            MenuItem::subMenu('Lista de Valores ', 'fa fa-gears')->setSubItems([
                MenuItem::section('Equipo de Trabajo'),
                MenuItem::linkToCrud('Gestión de Usuarios ', '', Usuario::class),
                MenuItem::section('Mantenedores'),
                MenuItem::linkToCrud('Gestión de Cupones ', '', Cupon::class),
            ]),
        ];
    }




}
