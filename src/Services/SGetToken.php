<?php
namespace App\Service;

class SGetToken
{

    public function getBearerToken($email, $password, $client)
    {
        //Get JWT Token with ROLE_ADMIN
        if ($email && $password) {

            $response = $client->request(
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
                $bearerToken = $content['token'];
                
                return $bearerToken;
            }

        }
    }

}