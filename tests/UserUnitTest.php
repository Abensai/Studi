<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    private const EMAIL_TEST = 'ali@test.com';
    private const PRENOM_TEST = 'Ali';
    private const NOM_TEST = 'BEN SAIAD';
    private const PASSWORD_TEST = 'password';
    private const TELEPHONE_TEST = '+(33)0606060606';

    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL_TEST)
            ->setPrenom(self::PRENOM_TEST)
            ->setNom(self::NOM_TEST)
            ->setPassword(self::PASSWORD_TEST)
            ->setTelephone(self::TELEPHONE_TEST);

        $this->assertEquals(self::EMAIL_TEST, $user->getEmail());
        $this->assertEquals(self::PRENOM_TEST, $user->getPrenom());
        $this->assertEquals(self::NOM_TEST, $user->getNom());
        $this->assertEquals(self::PASSWORD_TEST, $user->getPassword());
        $this->assertEquals(self::TELEPHONE_TEST, $user->getTelephone());
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
}
