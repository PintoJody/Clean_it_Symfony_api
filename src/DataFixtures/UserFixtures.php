<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\StatutRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $statutRepo;
    private $passwordHasher;

    public function __construct(StatutRepository $statutRepository, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->statutRepo = $statutRepository;
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {

        //Get Statut Actif
        $statut = $this->statutRepo->findOneBy(["name" => "actif"]);
        //PlainPassword
        $plainPassword = "admin";
        
        $user = new User();
        $user
            ->setEmail("admin@dev.com")
            ->setName("AdminDev")
            ->setPlainPassword($plainPassword)
            ->setPicture("/assets/imgs/badge.png")
            ->setStatut($statut)
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordHasher->hashPassword($user, $plainPassword))
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
