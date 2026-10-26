<?php

use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Models\User;
use App\Services\GitHub\GitHubApi;
use Database\Factories\ReceiptFactory;
use Illuminate\Http\RedirectResponse;
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
        ->assertOk()
        ->assertSessionHas('laravel_flash_message.level', 'error')
        ->assertSessionHas('laravel_flash_message.message', 'Your GitHub account is connected, but repository access could not be restored. Please try again or contact support.');

    $this->assertAuthenticated();
});

it('connects GitHub to the signed in account and returns to purchases', function () {
    $user = User::factory()->create(['email' => 'purchaser@example.com']);

    $provider = Mockery::mock();
    $provider->shouldReceive('redirect')->once()->andReturn(new RedirectResponse('https://github.com/login/oauth/authorize'));
    $provider->shouldReceive('stateless')->andReturnSelf();
    $provider->shouldReceive('user')->once()->andReturn(SocialiteUser::fake([
        'id' => '12345',
        'nickname' => 'connected-user',
        'email' => 'different-github-email@example.com',
    ]));
    Socialite::shouldReceive('driver')->with('github')->andReturn($provider);
    $this->mock(RestoreRepositoryAccessAction::class)
        ->shouldReceive('execute')->once()->with(Mockery::on(fn (User $connectedUser) => $connectedUser->is($user)));

    $this->actingAs($user)
        ->get(route('github-login'))
        ->assertRedirect('https://github.com/login/oauth/authorize');

    $this->get('login/github/callback?code=123&state=state')
        ->assertOk()
        ->assertViewHas('redirectUrl', route('purchases'))
        ->assertSessionMissing('auth-user-id')
        ->assertSessionMissing('next');

    expect($user->fresh())
        ->github_username->toBe('connected-user')
        ->email->toBe('purchaser@example.com');
    $this->assertAuthenticatedAs($user);
});

it('preserves the next page for a regular GitHub login', function () {
    $provider = Mockery::mock();
    $provider->shouldReceive('stateless')->andReturnSelf();
    $provider->shouldReceive('user')->andReturn(SocialiteUser::fake([
        'id' => '12345',
        'nickname' => 'connected-user',
        'email' => 'github@example.com',
    ]));
    Socialite::shouldReceive('driver')->with('github')->andReturn($provider);
    $this->mock(RestoreRepositoryAccessAction::class)->shouldReceive('execute')->once();

    $this->withSession(['next' => route('profile')])
        ->get('login/github/callback?code=123&state=state')
        ->assertOk()
        ->assertViewHas('redirectUrl', route('profile'))
        ->assertSessionMissing('next');
});

it('restores eligible repository access when reconnecting or changing GitHub accounts', function (?string $previousGitHubId, ?string $previousGitHubUsername) {
    $user = User::factory()->create([
        'github_id' => $previousGitHubId,
        'github_username' => $previousGitHubUsername,
    ]);
    $purchasable = Purchasable::factory()->create([
        'repository_access' => 'spatie/laravel-mailcoach',
        'requires_license' => true,
    ]);
    $purchase = Purchase::factory()->create([
        'user_id' => $user->id,
        'purchasable_id' => $purchasable->id,
        'receipt_id' => ReceiptFactory::new()->create()->id,
    ]);
    $assignments = collect([now()->addYear(), now()->subDay()])->map(function ($expiresAt) use ($user, $purchase, $purchasable) {
        $assignment = PurchaseAssignment::factory()->create([
            'user_id' => $user->id,
            'purchase_id' => $purchase->id,
            'purchasable_id' => $purchasable->id,
            'has_repository_access' => true,
        ]);
        License::factory()->create([
            'purchase_assignment_id' => $assignment->id,
            'expires_at' => $expiresAt,
        ]);

        return $assignment;
    });
    $provider = Mockery::mock();
    $provider->shouldReceive('stateless')->andReturnSelf();
    $provider->shouldReceive('user')->andReturn(SocialiteUser::fake([
        'id' => '67890',
        'nickname' => 'reconnected-user',
        'email' => $user->email,
    ]));
    Socialite::shouldReceive('driver')->with('github')->andReturn($provider);
    $this->mock(GitHubApi::class)->shouldReceive('inviteToRepo')
        ->once()->with('reconnected-user', 'spatie/laravel-mailcoach');

    $this->actingAs($user)
        ->withSession(['auth-user-id' => $user->id])
        ->get('login/github/callback?code=123&state=state')
        ->assertOk()
        ->assertSessionHas('laravel_flash_message.level', 'success');

    expect($user->fresh())->github_username->toBe('reconnected-user');
    expect($assignments->first()->fresh()->has_repository_access)->toBeTrue();
    expect($assignments->last()->fresh()->has_repository_access)->toBeFalse();
})->with([
    'disconnected account' => [null, null],
    'different account' => ['12345', 'previous-user'],
]);
