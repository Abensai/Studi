<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Form\BookingType;
use App\Repository\EstablishmentRepository;
use App\Repository\ServiceRepository;
use App\Repository\SuiteRepository;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstablishmentController extends AbstractController
{
    /**
     * @Route("/establishment", name="app_establishment")
     */
    public function index(EstablishmentRepository $establishmentRepository): Response
    {
        return $this->render('establishment/index.html.twig', [
            'establishments' => $establishmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/establishment/{id}", name="app_establishment_suite")
     */
    public function suites(Establishment $establishment,
                           SuiteRepository $suiteRepository,
                           ServiceRepository $serviceRepository,
                           BookingService $bookingService,
                           Request $request): Response
    {
        $suites = $suiteRepository->findEstablishment($establishment);
        $services = $serviceRepository->findAll();

        $booking = $bookingService->formPreFill($establishment);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$booking = $form->getData();
            // dd($check);
            // $bookingService->persistContact($booking);
           // return $this->json($check);
        }

        return $this->render('suite/index.html.twig', [
            'establishment' => $establishment,
            'suites' => $suites,
            'services' => $services,
            'form_booking' => $form->createView(),
        ]);
    }
}
