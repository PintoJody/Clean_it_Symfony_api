# Clean_it_Symfony_api

## Prérequis :
    -> OpenSSL : installer fichier .exe Win64 OpenSSL v3.0.7 Light => https://slproweb.com/products/Win32OpenSSL.html

## Mise en place :
    => Lancer commande : 

        composer i
        php bin/console lexik:jwt:generate-keypair
        php bin/console doctrine:database:create
        php bin/console make:migration
        php bin/console doctrine:migrations:migrate
        php bin/console doctrine:fixtures:load
        php bin/console app:postExternalApiDatas admin@dev.com admin

## Relation entre les entités :
    => Faire passer id unique (@id => exemple : api/user/1) dans le champs de relation.

## Connexion avec JWT Token : 
    => Requete : /authentication_token
