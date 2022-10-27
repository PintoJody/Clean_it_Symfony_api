<?php
namespace App\Service;

use App\Entity\Benne;
use App\Entity\Localisation;
use DateTime;
use DateTimeImmutable;

class SSendDatas
{

    public function sendDatas($array, $typeRepo, $etatBenneRepo, $localisationRepo, $manager)
    {

        //Verif if localisation exist 
        $exist = $localisationRepo->findOneBy([
            'latitude' => $array["latitude"], 
            'longitude' => $array["longitude"]
        ]);

        //Send Datas
        if($exist){
            $localisation = $exist;
        }else{
            $localisation = new Localisation();
            $localisation
                ->setAdress($array["adresse"])
                ->setLatitude($array["latitude"])
                ->setLongitude($array["longitude"])
                ->setDepartementCode($array["cp"])
                ->setRegionName("Ile-de-France")
                ->setDepartementName("Paris")
                ->setCityName("PARIS")
                ->setCreatedAt(new DateTimeImmutable())
                ->setUpdatedAt(new DateTimeImmutable());

            $manager->persist($localisation);
            $manager->flush();
        }

        //Add BENNE
        $benne = new Benne();
        $benne
            ->setLocalisation($localisation)
            ->setCapacite("0")
            ->setType($typeRepo->findOneBy(['name' => 'Verre']))
            ->setEtat($etatBenneRepo->findOneBy(['name' => 'disponible']))
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        $manager->persist($benne);
        $manager->flush();
    }

}