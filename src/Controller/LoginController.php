<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * El SecurityBundle ya se encarga de la validacion.
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'title' => 'Wine Measurements - Login',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Metodo vacio, el service ya se encarga de invalidar la sesion.
     * @param AuthenticationUtils $authenticationUtils
     * @return void
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(AuthenticationUtils $authenticationUtils)
    {
        // Blank controller, no extra logic required.
        // Once session is erased user will be redirected as configured on security.yaml > firewall > main > logout
    }
}
