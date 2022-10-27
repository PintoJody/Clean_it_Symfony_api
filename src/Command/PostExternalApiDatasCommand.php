<?php

namespace App\Command;

use App\Service\SGetOpenDatasApi;
use App\Service\SGetToken;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
    private $sGetToken;
    private $sGetOpenDatasApi;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
        $this->sGetToken = new SGetToken();
        $this->sGetOpenDatasApi = new SGetOpenDatasApi();

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

        //GET JWT Token with sGetToken Service
        $this->bearerToken = $this->sGetToken->getBearerToken($email, $password, $this->client);

        if(!empty($this->bearerToken)){
            $io->note(sprintf("Authentication SUCCESS !"));
            //Get OpenDatasApi Paris with sGetOpenDatasApi Service
            $datas = $this->sGetOpenDatasApi->getOpenDatasApi($this->client);

            if(!empty($datas)){
                $io->note(sprintf("Data array is ready !"));
            }else{
                $io->note(sprintf("Error with SGetOpenDatasApi Service."));
            }
            
        }else{

            $io->note(sprintf("Authentication ERROR !"));
        }

        //Send Datas

        // $io->success('Data added successfully!');

        return Command::SUCCESS;
    }
}
