<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(GalleryRepository $galleryRepository,
                          ServiceRepository $serviceRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'galleries' => $galleryRepository->lastFive(),
            'services' => $serviceRepository->findAll(),
        ]);
    }
}
