<?php

namespace App\Command;

use App\Repository\EtatBenneRepository;
use App\Repository\LocalisationRepository;
use App\Repository\TypeRepository;
use App\Service\SGetOpenDatasApi;
use App\Service\SGetToken;
use App\Service\SSendDatas;
use Doctrine\Persistence\ManagerRegistry;
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
    private $sSendDatas;
    private $typeRepo;
    private $localisationRepo;
    private $etatBenneRepo;
    private $manager;

    public function __construct(HttpClientInterface $httpClient, TypeRepository $typeRepository, LocalisationRepository $localisationRepository ,EtatBenneRepository $etatBenneRepository, ManagerRegistry $doctrine)
    {
        $this->client = $httpClient;
        $this->sGetToken = new SGetToken();
        $this->sGetOpenDatasApi = new SGetOpenDatasApi();
        $this->sSendDatas = new SSendDatas();
        $this->typeRepo = $typeRepository;
        $this->etatBenneRepo = $etatBenneRepository;
        $this->localisationRepo = $localisationRepository;
        $this->manager = $doctrine;

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
            $datasVerre = $this->sGetOpenDatasApi->getOpenDatasApi($this->client, "dechets-menagers-points-dapport-volontaire-colonnes-a-verre");
            $datasTextile = $this->sGetOpenDatasApi->getOpenDatasApi($this->client, "dechets-menagers-points-dapport-volontaire-conteneur-textile");
            $datasMenagers = $this->sGetOpenDatasApi->getOpenDatasApi($this->client, "dechets-menagers-points-dapport-volontaire-stations-trilib");
            $datasRecycleries = $this->sGetOpenDatasApi->getOpenDatasApi($this->client, "dechets-menagers-points-dapport-volontaire-recycleries-et-ressourceries");
            $datasComposteurs = $this->sGetOpenDatasApi->getOpenDatasApi($this->client, "dechets-menagers-points-dapport-volontaire-composteurs");

            if(!empty($datasVerre)){
                $io->note(sprintf("All data tables are ready !"));

                ////// Send Datas //////
                
                //Send datas Verre
                $io->note(sprintf("Send datas Verre ..."));
                foreach($datasVerre as $datas){
                    $this->sSendDatas->sendDatas($datas, $this->typeRepo, $this->etatBenneRepo, $this->localisationRepo ,$this->manager->getManager());
                }
                //Send datas Textile
                $io->note(sprintf("Send datas Textile ..."));
                foreach($datasTextile as $datas){
                    $this->sSendDatas->sendDatas($datas, $this->typeRepo, $this->etatBenneRepo, $this->localisationRepo ,$this->manager->getManager());
                }
                //Send datas Menagers
                $io->note(sprintf("Send datas Menagers ..."));
                foreach($datasMenagers as $datas){
                    $this->sSendDatas->sendDatas($datas, $this->typeRepo, $this->etatBenneRepo, $this->localisationRepo ,$this->manager->getManager());
                }
                //Send datas Recycleries
                $io->note(sprintf("Send datas Recycleries ..."));
                foreach($datasRecycleries as $datas){
                    $this->sSendDatas->sendDatas($datas, $this->typeRepo, $this->etatBenneRepo, $this->localisationRepo ,$this->manager->getManager());
                }
                //Send datas Composteurs
                $io->note(sprintf("Send datas Composteurs ..."));
                foreach($datasComposteurs as $datas){
                    $this->sSendDatas->sendDatas($datas, $this->typeRepo, $this->etatBenneRepo, $this->localisationRepo ,$this->manager->getManager());
                }

                $io->note(sprintf("Data added successfully !"));
            }else{
                $io->note(sprintf("Error with SGetOpenDatasApi Service."));
            }
            
        }else{
            $io->note(sprintf("Authentication ERROR !"));
        }

        return Command::SUCCESS;
    }
}
