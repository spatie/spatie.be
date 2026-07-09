<?php

use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

it('does not fail the callback when repository access cannot be restored', function () {
    Http::fake([
        'https://api.github.com/graphql' => Http::response([
            'message' => 'Bad credentials',
        ], 401),
    ]);

    $provider = Mockery::mock();
    $provider->shouldReceive('stateless')->andReturnSelf();
    $provider->shouldReceive('user')->andReturn(SocialiteUser::fake([
        'id' => '12345',
        'nickname' => 'riasvdv',
        'email' => 'rias@example.com',
        'name' => 'Rias',
    ]));

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $this->app->bind(RestoreRepositoryAccessAction::class, function () {
        throw new TypeError('GitHub token is missing.');
    });

    $this
        ->get('login/github/callback?code=123&state=state')
        ->assertOk();

    $this->assertAuthenticated();
});
