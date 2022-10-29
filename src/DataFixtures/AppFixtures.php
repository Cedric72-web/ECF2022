<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User($this->passwordHasher);
        $admin->setLastname("N0t")
                ->setFirstname('Admin')
                ->setPassword('azerty')
                ->setEmail("admin@test.com")
                ->setRoles(["ROLE_ADMIN"])
                ->setUsername('N0t Admin');
        $manager->persist($admin);

        $franchise1 = new User($this->passwordHasher);
        $franchise1->setLastname("N0t")
                ->setFirstName('Franchise1')
                ->setPassword('azerty')
                ->setEmail("franchise1@test.com")
                ->setRoles(["ROLE_FRANCHISE"])
                ->setUsername('N0t Franchise1');
        $manager->persist($franchise1);

        $partner1 = new User($this->passwordHasher);
        $partner1->setLastname("N0t")
                ->setFirstName('Partner1')
                ->setPassword('azerty')
                ->setEmail("partner1@test.com")
                ->setRoles(["ROLE_PARTNER"])
                ->setUsername('N0t Partner1');
        $manager->persist($partner1);

        $manager->flush();
    }
}
