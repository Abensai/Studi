<?php

namespace App\Tests;

use App\Entity\Booking;
use App\Entity\Establishment;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    private const EMAIL_TEST = 'ali@test.com';
    private const PRENOM_TEST = 'Ali';
    private const NOM_TEST = 'BEN SAIAD';
    private const PASSWORD_TEST = 'password';
    private const TELEPHONE_TEST = '+(33)0606060606';
    private const ROLE = ['ROLE_USER'];

    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL_TEST)
            ->setPrenom(self::PRENOM_TEST)
            ->setNom(self::NOM_TEST)
            ->setPassword(self::PASSWORD_TEST)
            ->setTelephone(self::TELEPHONE_TEST)
            ->setRoles(self::ROLE)
            ->setIsVerified(false);

        $this->assertEquals($user->getUserIdentifier(), $user->getEmail());
        $this->assertEquals(self::PRENOM_TEST, $user->getPrenom());
        $this->assertEquals(self::NOM_TEST, $user->getNom());
        $this->assertEquals(self::PASSWORD_TEST, $user->getPassword());
        $this->assertEquals(self::TELEPHONE_TEST, $user->getTelephone());
        $this->assertEquals(self::ROLE, $user->getRoles());
        $this->assertEquals(false, $user->isVerified());
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL_TEST)
            ->setPrenom(self::PRENOM_TEST)
            ->setNom(self::NOM_TEST)
            ->setPassword(self::PASSWORD_TEST)
            ->setTelephone(self::TELEPHONE_TEST);

        $this->assertNotEquals('alain@test.com', $user->getEmail());
        $this->assertNotEquals('Alain', $user->getPrenom());
        $this->assertNotEquals('BENAR', $user->getNom());
        $this->assertNotEquals('passwwword', $user->getPassword());
        $this->assertNotEquals('+(33)0707070707', $user->getTelephone());
    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPrenom());
        $this->assertEmpty($user->getNom());
        $this->assertEmpty($user->getTelephone());
        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getSalt());
    }

    public function testRelationBooking(): void
    {
        $user = new User();
        $booking = new Booking();

        $user->addBooking($booking);
        $this->assertNotEmpty($user->getBooking());
        $user->removeBooking($booking);
    }

    public function testRelationEstablishment(): void
    {
        $user = new User();
        $establishment = new Establishment();

        $user->setEstablishment($establishment);
        $this->assertNotEmpty($user->getEstablishment());
    }

    public function testUserType(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL_TEST);

        $this->assertIsString($user->__toString());
        $this->assertEquals($user->getEmail(), $user->__toString());
        $this->assertIsObject($user->getUsername());
    }
}
