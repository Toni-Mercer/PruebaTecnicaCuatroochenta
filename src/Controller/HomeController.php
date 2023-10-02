<?php

namespace App\Controller;

use App\Entity\Reading;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        #[CurrentUser]
        User $user
    ): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Wine Measurements - Home',
        ]);
    }

    #[Route('/measurements', name: 'app_measurements')]
    public function measurements(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager
    ): Response
    {
        $readings = $entityManager->getRepository(Reading::class)->findAll();
        $data = [];
        foreach ($readings as $reading){
            $data[] = [
                'id' => $reading->getId(),
                'year' => $reading->getYear(),
                'variety' => $reading->getVariety(),
                'type' => $reading->getType(),
                'color' => $reading->getColor(),
                'temp' => $reading->getTemperature(),
                'graduation' => $reading->getGraduation(),
                'ph' => $reading->getPh(),
                'observations' => $reading->getObservations(),
            ];
        }

        return $this->json($data);
    }
}
