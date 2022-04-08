<?php

namespace App\Controller;

use App\Entity\Suite;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(GalleryRepository $galleryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'galleries' => $galleryRepository->lastFive(),
            // 'labelSuite' => $galleryRepository->getLabelSuite(Suite::class),
        ]);
    }
}
