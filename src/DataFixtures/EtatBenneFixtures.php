<?php

namespace App\DataFixtures;

use App\Entity\EtatBenne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatBenneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $typesArray = ["disponible", "indisponible",];

        foreach($typesArray as $item){
            $etat = new EtatBenne();
            $etat->setName($item);
            $manager->persist($etat);
        }

        $manager->flush();
    }
}
