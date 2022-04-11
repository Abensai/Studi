<?php

namespace App\Command;

use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Service\BookingService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendContactCommand extends Command
{
    private ContactRepository $contactRepository;
    private MailerInterface $mailer;
    private BookingService $contactService;
    private UserRepository $userRepository;
    protected static $defaultName = 'app:send-contact';

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface   $mailer,
        BookingService    $contactService,
        UserRepository    $userRepository
    ) {
        $this->contactRepository = $contactRepository;
        $this->mailer = $mailer;
        $this->contactService = $contactService;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * @throws NonUniqueResultException
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $toSend = $this->contactRepository->findBy(['statut' => false]);
        $address = new Address($this->userRepository->getUserAdmin()->getEmail(),
            $this->userRepository->getUserAdmin()->getNom().' '.
            $this->userRepository->getUserAdmin()->getPrenom());

        foreach ($toSend as $mail) {
            $email = (new Email())
                ->from($mail->getEmail())
                ->to($address)
                ->subject($mail->getSujet().' - '.$mail->getNom().' '.$mail->getPrenom())
                ->text($mail->getMessage());

            $this->mailer->send($email);
            $this->contactService->updateStatus($mail);
        }

        return Command::SUCCESS;
    }
}
