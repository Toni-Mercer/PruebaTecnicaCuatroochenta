<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * Redirect al login
     * @return Response
     */
    #[Route('/', name: 'app_public')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }
}
