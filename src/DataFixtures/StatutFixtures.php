<?php

namespace App\DataFixtures;

use App\Entity\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatutFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $typesArray = ["actif", "ban", "corbeille"];

        foreach($typesArray as $item){
            $statuts = new Statut();
            $statuts->setName($item);
            $manager->persist($statuts);
        }

        $manager->flush();
    }
}
