<?php
namespace App\Service;

use App\Entity\Benne;
use App\Entity\Localisation;
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
                ->setAdress(htmlspecialchars($array["adresse"]))
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

        //Format datas etatBenne
        if(strtoupper($array["etat"]) === "EN SERVICE" || $array["etat"] === ""){
            $etat = $etatBenneRepo->findOneBy(['name' => 'disponible']);
        }else{
            $etat = $etatBenneRepo->findOneBy(['name' => 'indisponible']);
        }
        //Format datas typeBenne
        if($array["type"] === "VERRE"){
            $type = $typeRepo->findOneBy(['name' => 'Verre']);
        }
        elseif($array["type"] === "TEXTILE"){
            $type = $typeRepo->findOneBy(['name' => 'Textile']);
        }
        elseif($array["type"] === "MENAGERS"){
            $type = $typeRepo->findOneBy(['name' => 'Menagers']);
        }
        elseif($array["type"] === "RECYCLERIES"){
            $type = $typeRepo->findOneBy(['name' => 'Recycleries']);
        }
        elseif($array["type"] === "COMPOSTEURS"){
            $type = $typeRepo->findOneBy(['name' => 'Composteurs']);
        }

        //Add BENNE
        $benne = new Benne();
        $benne
            ->setLocalisation($localisation)
            ->setCapacite("0")
            ->setType($type)
            ->setEtat($etat)
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());

        $manager->persist($benne);
        $manager->flush();
    }

}