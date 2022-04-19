<?php

namespace App\DataFixtures;

use App\Entity\Establishment;
use App\Entity\Gallery;
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

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Data
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
            '0' => [
                'name' => 'Continental Hotel and Casino',
                'image' => '/build/images/tholaal-mohamed.jpg',
            ],
            '1' => [
                'name' => 'Plaza Hotel',
                'image' => '/build/images/valeriia-bugaiova.jpg',
            ],
            '2' => [
                'name' => 'Ritz-Carlton Hotel',
                'image' => '/build/images/fernando-alvarez-rodriguez.jpg',
            ],
        ];
        $nameService = [
            'Champagne',
            'Parking',
            'Sport',
            'Flowers',
            'Restaurant',
            'Spa / Hammam / Massage',
        ];
        $iconService = [
            'fa-solid fa-champagne-glasses',
            'fa-solid fa-square-parking',
            'fa-solid fa-dumbbell',
            'fa-solid fa-leaf',
            'fa-solid fa-utensils',
            'fa-solid fa-spa',
        ];
        $counter = 0;

        // User & Establishment Fixtures
        foreach ($user->userAll as $email) {
            $user = new User();

            $user->setEmail($email)
                ->setNom($faker->firstName())
                ->setPrenom($faker->lastName())
                ->setTelephone($faker->phoneNumber());

            $user->setPassword(self::hashPassword($user));

            if (str_contains($email, 'manager')) {
                $establishment = new Establishment();

                $establishment->setNom($hotels[$counter]['name'])
                    ->setAdresse($faker->address())
                    ->setVille($faker->city())
                    ->setDescription($faker->text(350))
                    ->setPageWeb($faker->url())
                    ->setUser($user)
                    ->setSlug($faker->slug(3))
                    ->setImage($hotels[$counter]['image']);
                $manager->persist($establishment);

                $user->setEstablishment($establishment);

                $this->addReference('establishment_'.$counter, $establishment);

                ++$counter;
            }

            $manager->persist($user);
        }

        // Suite Fixtures
        $key = 0;
        for ($i = 0; $i < 3; ++$i) {
            for ($j = 1; $j < 7; ++$j) {
                $suite = new Suite();

                $suite->setTitre($faker->words(3, true))
                    ->setDescription($faker->text(250))
                    ->setSlug($faker->slug(3))
                    ->setEstablishment($this->getReference("establishment_$i"))
                    ->setDisponibilite(true)
                    ->setLienBooking($faker->url())
                    ->setPrix($faker->randomFloat(2, 500, 9999))
                    ->setImage('/build/images/lux-'.strval($j).'.jpg');

                $this->addReference('suite_'.$key, $suite);

                $manager->persist($suite);
                ++$key;
            }
        }

        // Service Fixtures
        $key = 0;
        for ($j = 0; $j < 6; ++$j) {
            $service = new Service();

            $service->setTitre($nameService[$j])
                ->setDescription($faker->text(200))
                ->setPrix($faker->randomFloat(2, 10, 999))
                ->setSlug($faker->slug(3))
                ->setIcon($iconService[$j]);

            $this->addReference('service_'.$key, $service);

            $manager->persist($service);
            ++$key;
        }

        for ($i = 0; $i < 18; ++$i) {
            for ($j = 0; $j < 4; ++$j) {
                $randomKey = random_int(0, 5);
                $suite = $this->getReference("suite_$i");
                $service = $this->getReference("service_$randomKey");
                $service->addSuite($suite);
                $suite->addService($service);

                $manager->persist($service);
                $manager->persist($suite);
            }
        }

        // Gallery Fixtures
        $galleryCollection = [];
        foreach (glob('./assets/gallery/*') as $filename) {
            $filename = explode('/', $filename);
            $galleryCollection[] = '/build/images/'.$filename[3];
        }

        $counterImg = 0;
        for ($i = 0; $i < 18; ++$i) {
            for ($j = 0; $j < 3; ++$j) {
                $gallery = new Gallery();

                $gallery->setTitre(self::getImageName($galleryCollection[$counterImg]))
                    ->setLien($galleryCollection[$counterImg])
                    ->setSlug($faker->slug())
                    ->setSuite($this->getReference("suite_$i"));
                $manager->persist($gallery);
                ++$counterImg;
            }
        }

        // Test Fonctionnel Fixtures

        $establishmentTest = new Establishment();

        $establishmentTest->setNom('Etablissement Test')
            ->setAdresse('1 rue test')
            ->setVille('Test')
            ->setDescription('Etablissement créé pour les test fonctionnels')
            ->setPageWeb('www.test.com')
            ->setSlug('establishment-test')
            ->setImage('/build/images/hotel-plaza-gold.jpeg');

        $suiteTest = new Suite();

        $suiteTest->setTitre('Suite Test')
            ->setSlug('suite-test')
            ->setPrix(1000)
            ->setDescription('Suite créé pour les test fonctionnels')
            ->setDisponibilite(true)
            ->setImage('/build/images/lux-1.jpg')
            ->setLienBooking('www.booking.com/suite-test')
            ->setEstablishment($establishmentTest);

        $manager->persist($establishmentTest);
        $manager->persist($suiteTest);

        $manager->flush();
    }

    private function hashPassword(User $user): string
    {
        return $this->passwordHashes->hashPassword(
            $user, 'password'
        );
    }

    /**
     * @return mixed|string
     */
    private function getImageName(string $url)
    {
        $name = explode('/', $url);
        $name = explode('.', $name[3]);

        return $name[0];
    }
}
