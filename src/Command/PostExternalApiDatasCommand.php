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
                $io->note(sprintf($this->bearerToken));
            }
            else{
                $io->note(sprintf('Authentication failed'));
            }
        }

        //


        // $io->success('Data added successfully!');

        return Command::SUCCESS;
    }
}
