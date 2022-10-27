<?php
namespace App\Service;

class SGetOpenDatasApi
{

    public function getOpenDatasApi($client)
    {
        //Get OpenDatasApi Paris
        $response = $client->request(
            'GET',
            'https://opendata.paris.fr/api/records/1.0/search/?dataset=dechets-menagers-points-dapport-volontaire-colonnes-a-verre', [
                'headers' => ['content-type:application/json'],
            ]
        );

        if($response->getStatusCode() === 200){
            //Get Total Benne
            $content = $response->getContent();
            $content = $response->toArray();
            $totalBenne = $content["nhits"];
            
            if(!empty($totalBenne)){
                $result = $client->request(
                    'GET',
                    'https://opendata.paris.fr/api/records/1.0/search/?dataset=dechets-menagers-points-dapport-volontaire-colonnes-a-verre&rows='.$totalBenne, [
                        'headers' => ['content-type:application/json'],
                    ]
                );
                $fullDatas = $result->getContent();
                $fullDatas = $result->toArray();
    
                //Get datas in an array
                $i = 0;
                $datasArray = [];
                foreach($fullDatas["records"] as $item){
                   $datasArray[$i]["type"] = $item["fields"]["flux"];
                   $datasArray[$i]["etat"] = $item["fields"]["etat"]; 
                   $datasArray[$i]["cp"] = $item["fields"]["code_postal"]; 
                   $datasArray[$i]["adresse"] = $item["fields"]["adresse"]; 
                   $datasArray[$i]["longitude"] = $item["geometry"]["coordinates"][0]; 
                   $datasArray[$i]["latitude"] = $item["geometry"]["coordinates"][1];
                   $i++;
                }

            }
            
            return $datasArray;
        }
    }

}