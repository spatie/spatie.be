<?php

namespace App\Services\Patreon;

use App\Services\Patreon\Resources\Campaign;
use App\Services\Patreon\Resources\Pledge;
use App\Services\Patreon\Resources\ResourceCollection;
use App\Services\Patreon\Resources\Reward;
use App\Services\Patreon\Resources\User;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

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

    protected function request(string $endpoint): array
    {
        $response = null;

        $response = $this->client->get($endpoint);

        return json_decode($response->getBody(), true);
    }

    public function pledges($campaignId, string $endpoint = null): Collection
    {
        $data = $endpoint === null
            ? $this->request("campaigns/{$campaignId}/pledges?include=patron.null,reward")
            : $this->request($endpoint);

        $users = new ResourceCollection();
        $rewards = new ResourceCollection();

        foreach ($data['included'] as $included) {
            if ($included['type'] === 'user') {
                $users->add(User::import($included));
            }

            if ($included['type'] === 'reward') {
                $rewards->add(Reward::import($included));
            }
        }

        $pledges = new ResourceCollection();

        foreach ($data['data'] as $pledge) {
            $pledges->add(Pledge::import($pledge));
        }

        $pledges->each(function (Pledge $pledge) use ($users) {
            $pledge->setuser($users->get($pledge->userId));
        });

        if (array_key_exists('next', $data['links'])) {
            $pledges = $pledges->merge($this->pledges($campaignId, $data['links']['next']));
        }

        return $pledges;
    }

    public function campaigns(): Collection
    {
        $data = $this->request("current_user/campaigns?include=pledges");

        $campaigns = new Collection();

        foreach ($data['data'] as $campaign) {
            $campaigns->push(Campaign::import($campaign));
        }

        return $campaigns;
    }
}
