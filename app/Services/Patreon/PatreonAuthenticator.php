<?php

namespace App\Services\Patreon;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Spatie\Valuestore\Valuestore;

class PatreonAuthenticator
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var \Spatie\Valuestore\Valuestore */
    protected $valueStore;

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $clientSecret;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.patreon.com/oauth2/token',
        ]);

        $this->valueStore = Valuestore::make(storage_path('/app/patreon-access.json'));

        $this->clientId = $clientId;

        $this->clientSecret = $clientSecret;
    }

    public function autoRefresh(string $refreshToken = null) : array
    {
        $tokens = $this->getTokens();

        return $this->refresh($refreshToken ?? $tokens['refresh_token']);
    }

    protected function refresh($refreshToken) : array
    {
        $data = [
            "grant_type" => "refresh_token",
            "refresh_token" => $refreshToken,
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];

        try {
            $response = $this->client->request('post', 'token', [
                'query' => $data,
            ]);
        }catch (RequestException $exception){
            return $this->getTokens();
        }

        $tokens = json_decode($response->getBody(), true);

        $this->saveTokens($tokens);

        return $tokens;
    }

    protected function saveTokens($tokens)
    {
        $this->valueStore->put('access_token', $tokens['access_token']);
        $this->valueStore->put('refresh_token', $tokens['refresh_token']);
    }

    protected function getTokens(): array
    {
        $tokens = [];

        $tokens['access_token'] = $this->valueStore->get('access_token');
        $tokens['refresh_token'] = $this->valueStore->get('refresh_token');

        return $tokens;
    }

    public function getAccessToken(){
        return $this->getTokens()['access_token'];
    }

    public function getRefreshToken(){
        return $this->getTokens()['refresh_token'];
    }
}