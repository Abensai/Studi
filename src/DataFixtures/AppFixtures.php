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
     * @param ObjectManager $manager
     * @return void
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
            'Continental Hotel and Casino',
            'Plaza Hotel',
            'Ritz-Carlton Hotel',
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

                $establishment->setNom($hotels[$counter])
                    ->setAdresse($faker->address())
                    ->setVille($faker->city())
                    ->setDescription($faker->text(350))
                    ->setPageWeb($faker->url())
                    ->setUser($user)
                    ->setSlug($faker->slug(3));
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
            for ($j = 0; $j < 6; ++$j) {
                $suite = new Suite();

                $suite->setTitre($faker->words(3, true))
                    ->setDescription($faker->text(250))
                    ->setSlug($faker->slug(3))
                    ->setEstablishment($this->getReference("establishment_$i"))
                    ->setDisponibilite(true)
                    ->setLienBooking($faker->url())
                    ->setPrix($faker->randomFloat(2, 500, 9999))
                    ->setImage('gallery/lux-'.strval($j).'jpg');

                $this->addReference('suite_'.$key, $suite);

                $manager->persist($suite);
                ++$key;
            }
        }

        // Service Fixtures
        for ($i = 0; $i < 18; ++$i) {
            for ($j = 0; $j < 4; ++$j) {
                $service = new Service();

                $suite = $this->getReference("suite_$i");

                $service->setTitre($faker->words(3, true))
                    ->setDescription($faker->text(200))
                    ->setPrix($faker->randomFloat(2, 10, 999))
                    ->setSlug($faker->slug(3))
                    ->addSuite($suite);

                $suite->addService($service);

                $manager->persist($service);
            }
        }

        // Gallery Fixtures
        $galleryCollection = [];
        foreach (glob('./assets/gallery/*') as $filename) {
            $galleryCollection[] = $filename;
        }

        $counterImg = 0;
        for ($i = 0; $i < 18; ++$i) {
            for ($j = 0; $j < 3; ++$j) {
                $gallery = new Gallery();

                $gallery->setTitre(self::getImageName($galleryCollection[$counterImg]))
                    ->setLien($galleryCollection[$counterImg])
                    ->setTaille(filesize($galleryCollection[$counterImg]))
                    ->setSlug($faker->slug())
                    ->setSuite($this->getReference("suite_$i"));
                $manager->persist($gallery);
                ++$counterImg;
            }
        }

        $manager->flush();
    }

    /**
     * @param User $user
     * @return string
     */
    private function hashPassword(User $user): string
    {
        return $this->passwordHashes->hashPassword(
            $user, 'password'
        );
    }

    /**
     * @param string $url
     *
     * @return mixed|string
     */
    private function getImageName(string $url)
    {
        $name = explode('/', $url);
        $name = explode('.', $name[3]);

        return $name[0];
    }
}
