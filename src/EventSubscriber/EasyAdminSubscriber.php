<?php

namespace App\EventSubscriber;

use App\Entity\Establishment;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEstablishmentSlugAndUser'],
        ];
    }

    public function setEstablishmentSlugAndUser(BeforeEntityPersistedEvent $event)
    {

        $entity = $event->getEntityInstance();

        if (!($entity instanceof Establishment)) {
            return;
        }

        $slug = $this->slugger->slug($entity->getNom());
        $entity->setSlug($slug);
    }
}
