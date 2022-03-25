<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

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

        $this->assertEquals($user->getEmail() == self::EMAIL_TEST);
        $this->assertEquals($user->getPrenom() == self::PRENOM_TEST);
        $this->assertEquals($user->getNom() == self::NOM_TEST);
        $this->assertEquals($user->getPassword() == self::PASSWORD_TEST);
        $this->assertEquals($user->getTelephone() == self::TELEPHONE_TEST);
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL_TEST)
            ->setPrenom(self::PRENOM_TEST)
            ->setNom(self::NOM_TEST)
            ->setPassword(self::PASSWORD_TEST)
            ->setTelephone(self::TELEPHONE_TEST);

        $this->assertNotEquals($user->getEmail() == 'alain@test.com');
        $this->assertNotEquals($user->getPrenom() == 'Alain');
        $this->assertNotEquals($user->getNom() == 'BENAR');
        $this->assertNotEquals($user->getPassword() == 'passwwword');
        $this->assertNotEquals($user->getTelephone() == '+(33)0707070707');
    }
}
