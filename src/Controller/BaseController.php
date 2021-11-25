<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

Class BaseController extends AbstractController
{
    /**
    * @Route("/")
    */
    public function index(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('admin'));
    }

}
