<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $typesArray = ["Verre", "Textile", "Ordure", "Plastique", "Papier", "Metal", "Carton", "Dechetterie"];

        foreach($typesArray as $item){
            $types = new Type();
            $types->setName($item);
            $manager->persist($types);
        }

        $manager->flush();
    }
}
