<?php

namespace App\Services\Patreon;


use Exception;
use GuzzleHttp\Client;

class PatreonApi
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    public function __construct(string $accessToken)
    {
        $this->client = new Client([
            'base_uri' => 'https://www.patreon.com/api/oauth2/api/',
            'headers' => [
                'authorization' => "Bearer {$accessToken}",
            ],
        ]);
    }

    protected function request(string $endpoint) : array{
        $response = null;

        try{
            $response = $this->client->get($endpoint);
        }catch (Exception $exception){
           return [];
        }

        return json_decode($response->getBody(), true);
    }

    public function currentUser(){
        return $this->request('current_user');
    }

    public function campaigns(){
        return $this->request('current_user/campaigns?includes=pledges');
    }

    public function pledges($campaign){

    }
}