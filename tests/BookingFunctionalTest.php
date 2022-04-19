<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingFunctionalTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'HYPNOS Groupe Hôtelier');
    }

    public function testEstablishmentPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/establishment');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h6', 'ESTABLISHMENT');
    }

    public function testSuitePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/establishment/establishment-test');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Etablissement Test');
    }

    public function testCheckAvailabilitySuite(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/establishment/establishment-test');
        $form = $crawler->selectButton('Check availability')->form();

        $client->submit($form, [
            'booking[establishment]' => 13,
            'booking[suite]' => 73,
            'booking[date_debut][month]' => 4,
            'booking[date_debut][day]' => 18,
            'booking[date_debut][year]' => 2022,
            'booking[date_fin][month]' => 5,
            'booking[date_fin][day]' => 18,
            'booking[date_fin][year]' => 2022,
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();

        $client->submit($form, [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h6', 'You are Connected as admin@admin.com ! Logout');
    }

    public function testRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('Register')->form();

        $client->submit($form, [
            'registration_form[email]' => 'test@test.com',
            'registration_form[nom]' => 'test',
            'registration_form[prenom]' => 'test',
            'registration_form[telephone]' => '0609080706',
            'registration_form[plainPassword][first]' => 'password',
            'registration_form[plainPassword][second]' => 'password',
        ]);

        $this->assertResponseIsSuccessful();
    }
}
