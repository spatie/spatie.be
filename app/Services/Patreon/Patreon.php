<?php

namespace App\Services\Patreon;

use App\Services\Patreon\Resources\Campaign;
use App\Services\Patreon\Resources\Pledge;
use App\Services\Patreon\Resources\Reward;
use App\Services\Patreon\Resources\User;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Patreon
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function request(string $endpoint): array
    {
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody(), true);
    }

    public function campaigns(): Collection
    {
        $data = $this->request("current_user/campaigns?include=pledges,rewards");

        return $this->importCampaigns($data);
    }

    public function pledges($campaignId): Collection
    {
        return $this->fetchPledges("campaigns/{$campaignId}/pledges?include=patron.null,reward");
    }

    protected function fetchPledges(string $endpoint): Collection
    {
        $data = $this->request($endpoint);

        $pledges = $this->importPledges($data);

        if (array_key_exists('next', $data['links'])) {
            $pledges = $pledges->merge($this->fetchPledges($data['links']['next']));
        }

        return $pledges;
    }

    protected function importCampaigns(array $data): Collection
    {
        $rewards = $this->importRewards($data);

        return collect($data['data'])->map(function (array $item) use ($rewards) {
            $campagin = Campaign::import($item);

            $campagin->rewards = collect($item['relationships']['rewards']['data'])
                ->map(function ($item) use ($rewards) {
                    return $rewards->first(function (Reward $reward) use ($rewards, $item) {
                        return $reward->id === (int ) $item['id'];
                    });
                });

            return $campagin;
        });
    }

    protected function importPledges(array $data)
    {
        $users = $this->importUsers($data);
        $rewards = $this->importRewards($data);

        return collect($data['data'])->map(function (array $pledge) use ($rewards, $users) {
            $pledge = Pledge::import($pledge);

            $pledge->user = $users->first(function (User $user) use ($pledge) {
                return $user->id === $pledge->userId;
            });

            return $pledge;
        });
    }

    protected function importUsers(array $data): Collection
    {
        return collect($data['included'])->filter(function (array $item) {
            return $item['type'] === 'user';
        })->map(function ($item) {
            return User::import($item);
        })->values();
    }

    protected function importRewards(array $data): Collection
    {
        return collect($data['included'])->filter(function (array $item) {
            return $item['type'] === 'reward';
        })->map(function ($item) {
            return Reward::import($item);
        })->values();
    }
}
