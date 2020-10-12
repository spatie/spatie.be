<?php

namespace App\Services\GitHub;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GitHubGraphApi
{
    public function isSponsor($gitHubUserName): bool
    {
        $sponsorUserNames = collect($this->getAllSponsors())->pluck('username')->toArray();

        return in_array($gitHubUserName, $sponsorUserNames);
    }

    public function getAllSponsors(): array
    {
        return Cache::remember('sponsors', now()->addMinute(), function () {
            return array_map(function ($sponsor) {
                return [
                    'id' => $sponsor['sponsorEntity']['id'],
                    'tier_id' => $sponsor['tier']['id'],
                    'tier_name' => $sponsor['tier']['name'],
                    'tier_description' => $sponsor['tier']['descriptionHTML'],
                    'tier_price' => $sponsor['tier']['monthlyPriceInDollars'],
                    'tier_price_in_cents' => $sponsor['tier']['monthlyPriceInCents'],
                    'username' => $sponsor['sponsorEntity']['login'],
                    'name' => $sponsor['sponsorEntity']['name'],
                    'email' => $sponsor['sponsorEntity']['email'],
                    'avatar' => $sponsor['sponsorEntity']['avatarUrl'],
                    'company' => $sponsor['sponsorEntity']['company'] ?? '',
                    'location' => $sponsor['sponsorEntity']['location'] ?? '',
                    'website' => $sponsor['sponsorEntity']['websiteUrl'] ?? '',
                    'created_at' => $sponsor['createdAt'],
                    'url' => $sponsor['sponsorEntity']['url'],
                ];
            }, $this->fetchRawSponsors());
        });
    }

    public function fetchRawSponsors($runningSponsors = [], $afterCursor = null)
    {
        $afterCursor = json_encode($afterCursor);

        $response = Http::withToken(config('services.github.token'))
            ->post('https://api.github.com/graphql', [
                'query' => <<<EOT
                {
                    organization(login: "spatie") {
                        sponsorshipsAsMaintainer(after: {$afterCursor}, first: 50, includePrivate: true) {
                          nodes {
                            id
                            tier {
                              id
                              descriptionHTML
                              monthlyPriceInDollars
                              monthlyPriceInCents
                              name
                            }
                            sponsorEntity {
                              ...on User {
                                avatarUrl
                                email
                                id
                                login
                                name
                                url
                                location
                                websiteUrl
                                company
                              }
                              ...on Organization {
                                avatarUrl
                                email
                                id
                                login
                                name
                                url
                                location
                                websiteUrl
                              }
                            }
                            createdAt
                          }
                          totalCount
                          pageInfo {
                            hasNextPage
                            endCursor
                          }
                        }
                      }
                  }
                EOT,
            ]);

        $sponsors = $response['data']['organization']['sponsorshipsAsMaintainer']['nodes'];
        $hasNextPage = $response['data']['organization']['sponsorshipsAsMaintainer']['pageInfo']['hasNextPage'];
        $endCursor = $response['data']['organization']['sponsorshipsAsMaintainer']['pageInfo']['endCursor'];

        $allSponsors = array_merge($runningSponsors, $sponsors);

        if (! $hasNextPage) {
            return $allSponsors;
        }

        return $this->fetchRawSponsors($allSponsors, $endCursor);
    }
}
