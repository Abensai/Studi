<?php

namespace App\Controller;

use App\Entity\Suite;
use App\Repository\SuiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiteController extends AbstractController
{
    /**
     * @Route("/suite", name="booking_suite")
     */
    public function index(SuiteRepository $suiteRepository): Response
    {
        $suites = $suiteRepository->findAll();
        $a = [];
        foreach ($suites as $suite) {
            $a[] = $suite->availabilitySuite();
        }

        return $this->json($a);
    }
}
