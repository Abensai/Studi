<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Suite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class BookingService
{
    private EntityManagerInterface $manager;
    private FlashBagInterface $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function formPreFill($establishment): Booking
    {
        $booking = new Booking();

        $booking->setEstablishment($establishment);

        return $booking;
    }

    public function updateStatus(Suite $suite): void
    {
        $suite->setDisponibilite(false);

        $this->manager->persist($suite);
        $this->manager->flush();
    }
}
