<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager): void
    {
        
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
