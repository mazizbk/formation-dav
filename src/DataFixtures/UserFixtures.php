<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $userhashPassword;

    /**
     * Class constructor.
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userhashPassword = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setPassword($this->userhashPassword->hashPassword('password'));
            $user->setRoles(['ROLE_USER']);
            $address = new Address();
            $address->setNumber($i + 1);
            $address->setStreet($faker->address);
            $user->setAddress($address);

            for ($v = 0; $v < 3; $v++) {
                $video = new Video();
                $video->setTitle($faker->title . ' ' . $v);
                $video->setUser($user);
                $manager->persist($video);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
