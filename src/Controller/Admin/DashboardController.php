<?php

namespace App\Controller\Admin;

use App\Entity\Establishment;
use App\Entity\Suite;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DashboardController extends AbstractDashboardController
{
    private AuthenticationUtils $authenticationUtils;
    private UserRepository $userRepository;

    public function __construct(AuthenticationUtils $authenticationUtils, UserRepository $userRepository)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hypnos Group Hotel');
    }

    /**
     * @throws NonUniqueResultException
     */
    public function configureMenuItems(): iterable
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $manager = $this->userRepository->getUser($lastUsername);

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if (in_array('ROLE_ADMIN', $manager->getRoles())) {
            yield MenuItem::linkToCrud('Establishment', 'fa fa-building-o', Establishment::class);
            yield MenuItem::linkToCrud('User', 'fa fa-users', User::class);
            yield MenuItem::linkToCrud('Suite', 'fa fa-bed', Suite::class);
        }

        if (in_array('ROLE_MANAGER', $manager->getRoles())) {
            yield MenuItem::linkToCrud('Suite', 'fa fa-bed', Suite::class);
        }
    }
}
