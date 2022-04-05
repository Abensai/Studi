<?php

namespace App\DataFixtures;

use App\Entity\Establishment;
use App\Entity\Service;
use App\Entity\Suite;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use stdClass;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHashes;

    public function __construct(UserPasswordHasherInterface $passwordHashes)
    {
        $this->passwordHashes = $passwordHashes;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new stdClass();
        $user->userAll = [
            'admin@admin.com',
            'customer-one@customer.com',
            'customer-two@customer.com',
            'manager-one@manager.com',
            'manager-two@manager.com',
            'manager-three@manager.com',
        ];
        $user->admin = 'admin@admin.com';
        $user->customer = [
            'customer-one@customer.com',
            'customer-two@customer.com',
        ];
        $user->manager = [
            'manager-one@manager.com',
            'manager-two@manager.com',
            'manager-three@manager.com', ];
        $hotels = [
            'Continental Hotel and Casino',
            'Plaza Hotel',
            'Ritz-Carlton Hotel',
        ];

        $counter = 0;
        foreach ($user->userAll as $email) {
            $user = new User();

            $user->setEmail($email)
                ->setNom($faker->firstName())
                ->setPrenom($faker->lastName())
                ->setTelephone($faker->phoneNumber());

            $user->setPassword(self::hashPassword($user));
            $manager->persist($user);

            if (str_contains($email, 'manager')) {
                $establishment = new Establishment();

                $establishment->setNom($hotels[$counter])
                    ->setAdresse($faker->address())
                    ->setVille($faker->city())
                    ->setDescription($faker->text(350))
                    ->setPageWeb($faker->url())
                    ->setUser($user)
                    ->setSlug($faker->slug(3));

                $user->setEstablishment($establishment);
                $manager->persist($establishment);

                for ($i = 0; $i < 6; ++$i) {
                    $room = new Suite();

                    $room->setTitre($faker->words(3, true))
                        ->setDescription($faker->text(250))
                        ->setSlug($faker->slug(3))
                        ->setEstablishment($establishment)
                        ->setDisponibilite(true)
                        ->setLienBooking($faker->url())
                        ->setPrix($faker->randomFloat(2, 500, 9999))
                        ->setImage('gallery/lux-'.strval($i).'jpg');

                    $manager->persist($room);

                    for ($i = 0; $i < 6; ++$i) {
                        $service = new Service();

                        $service->setTitre($faker->words(3, true))
                            ->setDescription($faker->text(200))
                            ->setPrix($faker->randomFloat(2, 10, 999))
                            ->setSlug($faker->slug(3))
                            ->addSuite($room);

                        $room->addService($service);

                        $manager->persist($service);
                    }
                }
            }
        }

        $manager->flush();
    }

    private function hashPassword(User $user): string
    {
        return $this->passwordHashes->hashPassword(
            $user, 'password'
        );
    }
}
