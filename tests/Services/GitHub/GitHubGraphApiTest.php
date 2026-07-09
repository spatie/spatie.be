<?php

use App\Services\GitHub\GitHubGraphApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::forget('sponsors');
});

it('does not determine sponsor status when the GitHub sponsor request fails', function () {
    Http::preventStrayRequests();

    Http::fake([
        'https://api.github.com/graphql' => Http::response([
            'message' => 'Bad credentials',
        ], 401),
    ]);

    $gitHub = new GitHubGraphApi();

    expect($gitHub->determineSponsorStatus('freekmurze'))->toBeNull();
    expect($gitHub->isSponsor('freekmurze'))->toBeFalse();
});

it('can determine if a user sponsors spatie', function () {
    Http::preventStrayRequests();

    Http::fake([
        'https://api.github.com/graphql' => Http::response([
            'data' => [
                'organization' => [
                    'sponsorshipsAsMaintainer' => [
                        'nodes' => [
                            [
                                'id' => 'sponsorship-id',
                                'tier' => [
                                    'id' => 'tier-id',
                                    'descriptionHTML' => 'Sponsor',
                                    'monthlyPriceInDollars' => 10,
                                    'monthlyPriceInCents' => 1000,
                                    'name' => 'Sponsor',
                                ],
                                'sponsorEntity' => [
                                    'avatarUrl' => 'https://example.com/avatar.png',
                                    'email' => 'freek@example.com',
                                    'id' => 'user-id',
                                    'login' => 'freekmurze',
                                    'name' => 'Freek',
                                    'url' => 'https://github.com/freekmurze',
                                    'location' => 'Antwerp',
                                    'websiteUrl' => 'https://freek.dev',
                                    'company' => 'Spatie',
                                ],
                                'createdAt' => '2026-07-09T00:00:00Z',
                            ],
                        ],
                        'totalCount' => 1,
                        'pageInfo' => [
                            'hasNextPage' => false,
                            'endCursor' => null,
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    expect((new GitHubGraphApi())->isSponsor('freekmurze'))->toBeTrue();
});
