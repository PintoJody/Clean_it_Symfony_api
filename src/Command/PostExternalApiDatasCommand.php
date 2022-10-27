<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:postExternalApiDatas',
    description: 'External API requests',
)]
class PostExternalApiDatasCommand extends Command
{
    private $client;
    private $bearerToken;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;

        parent::__construct();
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        //Get JWT Token with ROLE_ADMIN
        if ($email && $password) {
            $io->note(sprintf('Email : %s', $email));
            $io->note(sprintf('Password : %s', $password));

            $response = $this->client->request(
                'POST',
                'http://127.0.0.1:8000/authentication_token', [
                    'headers' => ['content-type:application/json'],
                        'body' => json_encode([
                            'email' => $email,
                            'password' => $password
                        ]),
                ]
            );

            if($response->getStatusCode() === 200){
                $content = $response->getContent();
                $content = $response->toArray();
                $this->bearerToken = $content['token'];
                // $io->note(sprintf($this->bearerToken));
            }
            else{
                $io->note(sprintf('Authentication failed'));
            }
        }

        //Get OpenDatasApi Paris
        $response = $this->client->request(
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
                $result = $this->client->request(
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
                $io->note(sprintf($datasArray[1]["longitude"]));
            }
    
        }else{
            $io->note(sprintf('Bad Request'));
        }


        // $io->success('Data added successfully!');

        return Command::SUCCESS;
    }
}
