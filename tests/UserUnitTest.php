<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail('ali@test.com')
            ->setPrenom('Ali')
            ->setNom('BEN SAIAD')
            ->setPassword('password')
            ->setTelephone('+(33)0606060606');

        $this->assertTrue($user->getEmail() == 'ali@test.com');
        $this->assertTrue($user->getPrenom() == 'Ali');
        $this->assertTrue($user->getNom() == 'BEN SAIAD');
        $this->assertTrue($user->getPassword() == 'password');
        $this->assertTrue($user->getTelephone() == '+(33)0606060606');
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail('ali@test.com')
            ->setPrenom('Ali')
            ->setNom('BEN SAIAD')
            ->setPassword('password')
            ->setTelephone('+(33)0606060606');

        $this->assertFalse($user->getEmail() == 'alain@test.com');
        $this->assertFalse($user->getPrenom() == 'Alain');
        $this->assertFalse($user->getNom() == 'BENAR');
        $this->assertFalse($user->getPassword() == 'passwwword');
        $this->assertFalse($user->getTelephone() == '+(33)0707070707');
    }
}
