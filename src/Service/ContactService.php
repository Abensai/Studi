<?php

namespace App\Service;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private EntityManagerInterface $manager;
    private FlashBagInterface $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function persistContact(Contact $contact): void
    {
        $contact->setStatut(false)
           ->setDate(new DateTime('now'));

        $this->manager->persist($contact);
        $this->manager->flush();
        $this->flash->add('success', 'Votre message est bien envoyé');
    }

    public function updateStatus(Contact $contact): void
    {
        $contact->setStatut(true);

        $this->manager->persist($contact);
        $this->manager->flush();
    }
}
