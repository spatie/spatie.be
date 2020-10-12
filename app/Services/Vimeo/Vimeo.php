<?php

namespace App\Services\Vimeo;

use GuzzleHttp\Client;

class Vimeo
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getVideos(): array
    {
        $response = $this->client->get('https://api.vimeo.com/me/videos', [
            'query' => [
                'per_page' => 100,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }

    public function getVideo(string $vimeo_id): array
    {
        $response = $this->client->get("https://api.vimeo.com/videos/{$vimeo_id}");

        return json_decode($response->getBody()->getContents(), true);
    }
}
