<?php

namespace App\Controller;

use App\Entity\Sensor;
use App\Entity\SensorType;
use App\Entity\User;
use App\Form\SensorFormType;
use App\Form\SensorTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SensorsController extends AbstractController
{
    #[Route('/sensors', name: 'app_sensors')]
    public function sensors(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensors = $entityManager->getRepository(Sensor::class)->findAll();

        return $this->render('sensors/sensors_list.html.twig', [
            'title' => 'Wine Measurements - Sensors',
            'sensors' => $sensors
        ]);
    }

    #[Route('/sensors/new', name: 'app_new_sensor')]
    public function newSensor(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensor = new Sensor();
        $form = $this->createForm(SensorFormType::class, $sensor);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $sensor->setValue($form->get('value')->getData());
            $sensor->setSensorType($form->get('sensorType')->getData());

            $entityManager->persist($sensor);
            $entityManager->flush();

            return $this->redirectToRoute('app_sensors');
        }

        return $this->render('sensors/new_sensor.html.twig', [
            'title' => 'Wine Measurements - New Sensor',
            'sensorForm' => $form->createView(),
            'error' => $error
        ]);
    }

    #[Route('/sensors/delete/{id}', name: 'app_delete_sensor')]
    public function deleteSensor(
        $id,
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensor = $entityManager->getRepository(Sensor::class)->find($id);
        $entityManager->remove($sensor);
        $entityManager->flush();

        return $this->redirectToRoute('app_sensors');
    }

    #[Route('/sensors/types', name: 'app_sensors_type')]
    public function sensorsType(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensorTypes = $entityManager->getRepository(SensorType::class)->findAll();

        return $this->render('sensors/sensor_type_list.html.twig', [
            'title' => 'Wine Measurements - Sensor Types',
            'sensorTypes' => $sensorTypes
        ]);
    }

    #[Route('/sensors/types/new', name: 'app_new_sensors_type')]
    public function newSensorType(
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensorType = new SensorType();
        $form = $this->createForm(SensorTypeFormType::class, $sensorType);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $sensorTypeTmp = $entityManager->getRepository(SensorType::class)->findOneBy(['name' => $form->get('name')->getData()]);

            if (is_null($sensorTypeTmp)){
                $sensorType->setName($form->get('name')->getData());

                $entityManager->persist($sensorType);
                $entityManager->flush();

                return $this->redirectToRoute('app_sensors_type');
            }
            $error = 'Este sensor ya existe.';
        }

        return $this->render('sensors/new_sensor_type.html.twig', [
            'title' => 'Wine Measurements - New Sensor Type',
            'sensorTypeForm' => $form->createView(),
            'error' => $error
        ]);
    }

    #[Route('/sensors/types/delete/{id}', name: 'app_delete_sensors_type')]
    public function deleteSensorsType(
        $id,
        #[CurrentUser]
        User $user,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $sensorType = $entityManager->getRepository(SensorType::class)->find($id);
        $entityManager->remove($sensorType);
        $entityManager->flush();

        return $this->redirectToRoute('app_sensors_type');
    }
}
