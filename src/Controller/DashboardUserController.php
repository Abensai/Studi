<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Repository\EstablishmentRepository;
use App\Repository\SuiteRepository;
use App\Repository\UserRepository;
use App\Service\BookingService;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DashboardUserController extends AbstractController
{
    /**
     * @Route("/infos", name="app_infos")
     *
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    public function index(AuthenticationUtils $authenticationUtils,
                            UserRepository $userRepository,
                            BookingService $bookingService,
                            EstablishmentRepository $establishmentRepository,
                            SuiteRepository $suiteRepository,
                            Request $request): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $infos = $userRepository->getUser($lastUsername);

        if (isset($_COOKIE['dataBooking'])) {
            $dataBooking = explode(',', $_COOKIE['dataBooking']);
            $validateData = [
                'user' => $infos,
                'establishment' => current($establishmentRepository->findById($dataBooking[0])),
                'suite' => current($suiteRepository->findById($dataBooking[1])),
                'date_debut' => new DateTime($dataBooking[2]),
                'date_fin' => new DateTime($dataBooking[3]),
            ];

            $booking = $bookingService->formToValidate($validateData);

            $form = $this->createForm(BookingType::class, $booking);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $validateBooking = $form->getData();

                $bookingService->persistBooking($validateBooking);

                setcookie('dataBooking', '', time() - (2 * 24 * 60 * 60 * 1000));
                return $this->redirectToRoute('app_infos');
            }

            return $this->render('connect/infos.html.twig', [
                'userInfos' => $infos,
                'form_validate' => $form->createView(),
            ]);
        }

        return $this->render('connect/infos.html.twig', [
            'userInfos' => $infos,
        ]);
    }
}
