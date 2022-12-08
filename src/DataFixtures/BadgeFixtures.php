<?php

namespace App\DataFixtures;

use App\Entity\Badge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BadgeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $badgeArray = [
            [
                "title" => "Initié",
                "picture" => "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Icone_%C3%A9cologie_humaine.svg/480px-Icone_%C3%A9cologie_humaine.svg.png",
                "describe" => "Vous avez rejoint la communauté Clean'it ! Cadeau de bienvenue !",
                "identity" => "01"
            ],
            [
                "title" => "Eco-responsable",
                "picture" => "https://cdn-icons-png.flaticon.com/512/1706/1706196.png",
                "describe" => "Premier tri effectué avec Clean'it",
                "identity" => "02"
            ],
            [
                "title" => "A la maison",
                "picture" => "https://cdn-icons-png.flaticon.com/512/861/861121.png",
                "describe" => "Enregistrement d'une adresse",
                "identity" => "03"
            ],
            [
                "title" => "Métamorphose",
                "picture" => "https://cdn-icons-png.flaticon.com/512/2849/2849891.png",
                "describe" => "Vous avez changé de pseudo pour la première fois !",
                "identity" => "04"
            ],
        ];

        foreach($badgeArray as $item){
            $badge = new Badge();
            $badge->setTitre($item["title"]);
            $badge->setImage($item["picture"]);
            $badge->setDescription($item["describe"]);
            $badge->setIdentity($item["identity"]);
            
            $manager->persist($badge);
        }

        $manager->flush();
    }
}
