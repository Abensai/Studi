<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="app_history")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(BookingRepository $bookingRepository, UserRepository $userRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $userRepository->getUser($authenticationUtils->getLastUsername());
        $history = $bookingRepository->findById($user);

        return $this->render('connect/history.html.twig', [
            'histories' => $history,
        ]);
    }
}
