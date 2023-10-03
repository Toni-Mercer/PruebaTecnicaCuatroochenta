<?php

namespace App\Controller;

use App\Entity\Reading;
use App\Entity\ReadingLog;
use App\Entity\User;
use App\Form\ReadingFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    /**
     * Pagina inicial tras el login
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/home', name: 'app_home')]
    public function index(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager
    ): Response
    {
        $logs = $entityManager->getRepository(ReadingLog::class)->getTodayReadingsLog($user->getId());

        return $this->render('home/index.html.twig', [
            'title' => 'Wine Measurements - Home',
            'showNewReadingButton' => count($logs) == 0
        ]);
    }

    /**
     * Devuelve las rows como json para el ajax de la home.
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
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

    /**
     * Creación de una lectura
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    #[Route('/readings/new', name: 'app_new_reading')]
    public function newReading(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $reading = new Reading();

        $today = new \DateTime();
        $reading->setYear($today->format('Y'));

        $form = $this->createForm(ReadingFormType::class, $reading);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $reading->setYear($form->get('year')->getData());
            $reading->setVariety($form->get('variety')->getData());
            $reading->setType($form->get('type')->getData());
            $reading->setColor($form->get('color')->getData());
            $reading->setTemperature($form->get('temperature')->getData());
            $reading->setGraduation($form->get('graduation')->getData());
            $reading->setPh($form->get('ph')->getData());

            $observations = $form->get('observaciones')->getData();
            if (!is_null($observations)) $reading->setObservations($observations);

            $entityManager->persist($reading);
            $entityManager->flush();

            $readingLog = new ReadingLog();
            $readingLog->setDate($today);
            $readingLog->setUserId($user->getId());
            $readingLog->setReading($reading);

            $entityManager->persist($readingLog);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/new_reading.html.twig', [
            'title' => 'Wine Measurements - Home',
            'readingForm' => $form->createView(),
            'error' => $error
        ]);
    }
}
