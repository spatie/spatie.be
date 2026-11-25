<?php

use App\Actions\UnsubscribeUserFromNewsletterAction;
use App\Domain\Blog\Models\BlogPost;
use App\Domain\Shop\Actions\RestoreRepositoryAccessAction;
use App\Filament\Resources\AdminAccessResource\Pages\ManageAdminAccess;
use App\Models\AdminAccess;
use App\Models\Member;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as GoogleUser;
use Livewire\Livewire;
use STS\FilamentImpersonate\Facades\Impersonation;

it('shows only Google sign-in to guests and password-authenticated administrators', function (bool $signedIn) {
    if ($signedIn) {
        $user = $this->actingAsSpatie();
        AdminAccess::query()->where('email', strtolower($user->email))->update(['google_id' => 'linked-google-id']);
    }

    $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
    $this->get('/admin/login')->assertOk()->assertSee('Continue with Google')
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
        ->assertDontSee('name="password"', false)->assertDontSee('GitHub');
})->with([false, true]);

it('does not grant staff privileges when registering an approved email address', function () {
    AdminAccess::create(['email' => 'pending@spatie.be']);
    Member::factory()->create(['email' => 'pending@spatie.be']);
    Http::fake([
        'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        'api.pwnedpasswords.com/*' => Http::response(''),
    ]);

    $this->post('/register', [
        'name' => 'Unverified customer',
        'email' => 'pending@spatie.be',
        'password' => 'a-long-registration-password',
        'password_confirmation' => 'a-long-registration-password',
        'cf-turnstile-response' => 'test-response',
    ])->assertRedirect(route('products.index'))->assertSessionHasNoErrors();

    $this->assertAuthenticated();
    expect(Auth::user()->isAdmin())->toBeFalse();
    expect(Auth::user()->isSpatieMember())->toBeFalse();
    $this->getJson('/api/members')->assertUnauthorized();
});

it('does not grant staff privileges through a customer profile email change', function () {
    AdminAccess::create(['email' => 'pending@spatie.be']);
    Member::factory()->create(['email' => 'pending@spatie.be']);
    $customer = User::factory()->create(['email' => 'customer@example.com']);
    $this->mock(UnsubscribeUserFromNewsletterAction::class)->shouldReceive('execute')->once();

    $this->actingAs($customer)->put('/profile', [
        'name' => $customer->name,
        'email' => 'pending@spatie.be',
    ])->assertRedirect('/profile')->assertSessionHasNoErrors();

    expect($customer->fresh()->email)->toBe('pending@spatie.be');
    expect($customer->fresh()->isAdmin())->toBeFalse();
    expect($customer->fresh()->isSpatieMember())->toBeFalse();
    $this->getJson('/api/members')->assertUnauthorized();
});

it('does not promote a preclaimed customer account during a verified Google callback', function (?string $linkedSubject) {
    $access = AdminAccess::create(['email' => 'preclaimed@spatie.be', 'google_id' => $linkedSubject]);
    $customer = User::factory()->create(['email' => $access->email, 'github_id' => 12345]);
    Member::factory()->create(['email' => $access->email]);
    $token = $customer->createToken('preexisting-token');
    $identity = (new GoogleUser())->setRaw(['email_verified' => true])->map([
        'id' => 'legitimate-google-subject', 'email' => $access->email, 'name' => 'Legitimate owner',
    ]);
    Socialite::shouldReceive('buildProvider')->with(GoogleProvider::class, config('services.google'))->andReturnSelf();
    Socialite::shouldReceive('user')->once()->andReturn($identity);

    $this->get(route('filament.admin.auth.google.callback'))
        ->assertRedirect(route('filament.admin.auth.login'))
        ->assertSessionHasErrors('google')->assertSessionMissing('admin_google_login');

    $this->assertGuest();
    expect($access->fresh()->user_id)->toBeNull();
    expect($customer->fresh()->password)->toBe($customer->password);
    expect($customer->fresh()->github_id)->toBe(12345);
    expect($customer->fresh()->isAdmin())->toBeFalse();
    expect($customer->fresh()->isSpatieMember())->toBeFalse();
    $this->withToken($token->plainTextToken)->getJson('/api/members')->assertUnauthorized();
})->with([null, 'legitimate-google-subject']);

it('does not replace a bound account after its email changes', function (bool $claimed) {
    $admin = $this->actingAsAdmin();
    $email = strtolower($admin->email);
    $access = $admin->adminAccess()->sole();
    $admin->update(['email' => 'changed@spatie.be']);

    if ($claimed) {
        User::factory()->create(['email' => $email]);
    }

    Auth::logout();
    $identity = (new GoogleUser())->setRaw(['email_verified' => true])->map([
        'id' => 'test-google-id', 'email' => $email, 'name' => 'Original owner',
    ]);
    Socialite::shouldReceive('buildProvider')->with(GoogleProvider::class, config('services.google'))->andReturnSelf();
    Socialite::shouldReceive('user')->once()->andReturn($identity);

    $this->get(route('filament.admin.auth.google.callback'))
        ->assertRedirect(route('filament.admin.auth.login'))->assertSessionHasErrors('google');

    $this->assertGuest();
    expect($access->fresh()->user_id)->toBe($admin->id);
    expect(User::count())->toBe($claimed ? 2 : 1);
})->with([false, true]);

it('starts stateful Google OAuth with an account chooser and domain hint', function () {
    config()->set('services.google', [
        'client_id' => 'test-client', 'client_secret' => 'test-secret',
        'redirect' => 'http://localhost/admin/auth/google/callback',
    ]);

    $response = $this->post(route('filament.admin.auth.google'))->assertRedirect()->assertSessionHas('state');
    parse_str(parse_url($response->headers->get('Location'), PHP_URL_QUERY), $query);

    expect($query)->toMatchArray(['hd' => 'spatie.be', 'prompt' => 'select_account', 'client_id' => 'test-client']);
    expect($query['state'])->not->toBeEmpty();
});

it('authenticates only approved verified Google identities and binds the session', function (bool $existing) {
    $user = $existing ? User::factory()->create(['email' => 'Approved@spatie.be']) : null;
    $access = AdminAccess::create(['email' => 'approved@spatie.be', 'user_id' => $user?->id]);
    $identity = (new GoogleUser())->setRaw(['email_verified' => true])->map([
        'id' => 'google-subject', 'email' => 'APPROVED@spatie.be', 'name' => 'Approved Staff',
    ]);
    Socialite::shouldReceive('buildProvider')->with(GoogleProvider::class, config('services.google'))->andReturnSelf();
    Socialite::shouldReceive('user')->once()->andReturn($identity);

    $this->get(route('filament.admin.auth.google.callback'))->assertRedirect(route('filament.admin.pages.dashboard'))
        ->assertSessionHas('admin_google_login', [
            'user_id' => $user?->id ?? User::query()->sole()->id,
            'email' => 'approved@spatie.be', 'google_id' => 'google-subject',
        ]);

    $this->assertAuthenticatedAs($user ?? User::query()->sole());
    expect($access->refresh()->google_id)->toBe('google-subject');
    expect($access->user_id)->toBe(Auth::id());
    expect(User::count())->toBe(1);
    expect(Auth::user()->isAdmin())->toBeTrue();
    $this->get(route('filament.admin.resources.admin-accesses.index'))->assertOk();
})->with([false, true]);

it('rejects unapproved, external, unverified and conflicting Google identities without creating accounts', function (string $email, mixed $verified, string $googleId, ?string $approved, ?string $linked) {
    if ($approved) {
        AdminAccess::create(['email' => $approved, 'google_id' => $linked]);
    }

    $identity = (new GoogleUser())->setRaw(['email_verified' => $verified])->map([
        'id' => $googleId, 'email' => $email, 'name' => 'Rejected Person',
    ]);
    Socialite::shouldReceive('buildProvider')->with(GoogleProvider::class, config('services.google'))->andReturnSelf();
    Socialite::shouldReceive('user')->once()->andReturn($identity);

    $this->get(route('filament.admin.auth.google.callback'))->assertRedirect(route('filament.admin.auth.login'))->assertSessionHasErrors('google');

    $this->assertGuest();
    expect(User::count())->toBe(0);
})->with([
    'unapproved staff' => ['staff@spatie.be', true, 'id', null, null],
    'external account' => ['person@example.com', true, 'id', 'person@example.com', 'id'],
    'lookalike domain' => ['staff@spatie.be.example.com', true, 'id', 'staff@spatie.be.example.com', 'id'],
    'unverified email' => ['staff@spatie.be', false, 'id', 'staff@spatie.be', null],
    'string false claim' => ['staff@spatie.be', 'false', 'id', 'staff@spatie.be', null],
    'missing subject' => ['staff@spatie.be', true, '', 'staff@spatie.be', null],
    'different subject' => ['staff@spatie.be', true, 'new-id', 'staff@spatie.be', 'original-id'],
]);

it('returns OAuth state failures and cancellation to admin sign-in', function () {
    config()->set('services.google', [
        'client_id' => 'test-client', 'client_secret' => 'test-secret',
        'redirect' => 'http://localhost/admin/auth/google/callback',
    ]);

    $this->withSession(['state' => 'expected-state'])
        ->get(route('filament.admin.auth.google.callback', ['state' => 'wrong-state', 'code' => 'code']))
        ->assertRedirect(route('filament.admin.auth.login'))->assertSessionHasErrors('google');
    $this->get(route('filament.admin.auth.google.callback', ['error' => 'access_denied']))->assertRedirect(route('filament.admin.auth.login'))->assertSessionHasErrors('google');
    $this->assertGuest();
});

it('does not grant admin access when restoring a remember cookie', function () {
    $user = $this->actingAsAdmin();
    Auth::guard('web')->login($user, true);
    $cookieName = Auth::guard('web')->getRecallerName();
    $cookie = "{$user->id}|{$user->getRememberToken()}|{$user->password}";
    session()->flush();
    Auth::forgetGuards();

    $this->withCookie($cookieName, $cookie)->get('/admin')
        ->assertRedirect(route('filament.admin.auth.login'))->assertSessionMissing('admin_google_login');
    $this->assertAuthenticatedAs($user);
});

it('keeps GitHub customer login working without preserving Google admin proof', function () {
    $user = $this->actingAsAdmin();
    $identity = (new GoogleUser())->map([
        'id' => '12345', 'email' => $user->email, 'name' => $user->name, 'nickname' => 'staff',
    ]);
    Socialite::shouldReceive('driver')->with('github')->andReturnSelf();
    Socialite::shouldReceive('stateless')->andReturnSelf();
    Socialite::shouldReceive('user')->andReturn($identity);
    $this->mock(RestoreRepositoryAccessAction::class)->shouldReceive('execute')->once();

    $this->get('/login/github/callback')->assertOk()->assertSessionMissing('admin_google_login');
    $this->assertAuthenticatedAs($user);
    $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
});

it('clears Google proof on a real password login and on logout', function () {
    $user = $this->actingAsAdmin();

    Auth::guard('web')->forgetUser();
    Auth::guard('web')->attempt(['email' => $user->email, 'password' => 'password']);

    $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'))->assertSessionMissing('admin_google_login');
    $this->assertAuthenticatedAs($user);

    $this->withSession(['admin_google_login' => [
        'user_id' => $user->id, 'email' => strtolower($user->email), 'google_id' => 'test-google-id',
    ]]);
    $this->post(route('filament.admin.auth.logout'))->assertRedirect()->assertSessionMissing('admin_google_login');
    $this->assertGuest();
});

it('requires current approval and identity for panel requests and blog previews', function (string $change) {
    $user = $this->actingAsAdmin();
    $post = BlogPost::factory()->create(['published' => false]);
    $panelUrl = route('filament.admin.resources.admin-accesses.index');
    $this->get($panelUrl)->assertOk();
    $this->get(route('blog.preview', $post))->assertOk();

    match ($change) {
        'revocation' => AdminAccess::query()->delete(),
        'subject change' => AdminAccess::query()->update(['google_id' => 'replacement-id']),
        'email change' => $user->update(['email' => 'different@spatie.be']),
        'identity switch' => $this->actingAs(User::factory()->create(['password' => $user->password])),
    };

    if ($change === 'identity switch') {
        AdminAccess::create(['email' => strtolower(Auth::user()->email), 'user_id' => Auth::id()]);
    }

    $this->get($panelUrl)->assertRedirect(route('filament.admin.auth.login'));
    $this->get(route('blog.preview', $post))->assertRedirect(route('filament.admin.auth.login'));
})->with(['revocation', 'subject change', 'email change', 'identity switch']);

it('manages normalized Spatie approvals without changing customer accounts', function () {
    $this->actingAsAdmin();
    $customer = User::factory()->create(['email' => 'new@spatie.be']);

    Livewire::test(ManageAdminAccess::class)
        ->callAction('create', data: ['email' => ' NEW@spatie.be '])
        ->assertHasNoActionErrors();

    $access = AdminAccess::query()->where('email', 'new@spatie.be')->sole();
    expect($access->google_id)->toBeNull();
    expect($access->user_id)->toBeNull();
    expect($customer->isAdmin())->toBeFalse();

    Livewire::test(ManageAdminAccess::class)
        ->callAction('create', data: ['email' => 'new@spatie.be'])->assertHasActionErrors(['email' => 'unique']);
    Livewire::test(ManageAdminAccess::class)
        ->callAction('create', data: ['email' => 'person@example.com'])->assertHasActionErrors(['email' => 'ends_with']);

    Livewire::test(ManageAdminAccess::class)
        ->callAction(TestAction::make('delete')->table($access))->assertHasNoActionErrors();

    expect(AdminAccess::find($access->id))->toBeNull();
    expect($customer->fresh())->not->toBeNull();
    expect($customer->isAdmin())->toBeFalse();
});

it('preserves the last administrator and provides an explicit bootstrap command', function () {
    $this->artisan('admin:grant-access', ['email' => 'person@example.com'])->assertFailed();
    expect(AdminAccess::count())->toBe(0);
    $this->artisan('admin:grant-access', ['email' => ' First@Spatie.be '])->assertSuccessful();
    $this->artisan('admin:grant-access', ['email' => 'first@spatie.be'])->assertSuccessful();
    expect(AdminAccess::query()->sole()->email)->toBe('first@spatie.be');

    expect(fn () => AdminAccess::query()->sole()->revoke())->toThrow(Illuminate\Validation\ValidationException::class);
    expect(AdminAccess::count())->toBe(1);
});

it('requires an explicit verified user ID to recover an existing customer account without replacing a binding', function () {
    $user = User::factory()->create(['email' => 'trusted@spatie.be']);
    $other = User::factory()->create();

    $this->artisan('admin:grant-access', ['email' => $user->email, '--user-id' => $other->id])->assertFailed();
    expect(AdminAccess::count())->toBe(0);

    $this->artisan('admin:grant-access', ['email' => $user->email])->assertSuccessful();
    expect($user->isAdmin())->toBeFalse();

    $this->artisan('admin:grant-access', ['email' => $user->email, '--user-id' => $user->id])->assertSuccessful();
    $this->artisan('admin:grant-access', ['email' => $user->email, '--user-id' => $user->id])->assertSuccessful();
    expect($user->isAdmin())->toBeTrue();
    $this->actingAs($user)->get('/admin')->assertRedirect(route('filament.admin.auth.login'));

    $user->update(['email' => 'changed@spatie.be']);
    $other->update(['email' => 'trusted@spatie.be']);

    $this->artisan('admin:grant-access', ['email' => $other->email, '--user-id' => $other->id])->assertFailed();
    expect(AdminAccess::query()->sole()->user_id)->toBe($user->id);
    expect($other->isAdmin())->toBeFalse();
});

it('does not inherit admin access while impersonating and rechecks approval on return', function (bool $revoke) {
    $admin = $this->actingAsAdmin();
    $target = User::factory()->create();
    AdminAccess::create(['email' => strtolower($target->email), 'user_id' => $target->id, 'google_id' => 'target-google-id']);

    expect(Impersonation::enter($admin, $target, 'web'))->toBeTrue();
    $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));

    if ($revoke) {
        AdminAccess::query()->where('email', strtolower($admin->email))->sole()->revoke();
    }

    expect(Impersonation::leave())->toBeTrue();
    $response = $this->get(route('filament.admin.resources.admin-accesses.index'));
    $revoke ? $response->assertRedirect(route('filament.admin.auth.login')) : $response->assertOk();
})->with([false, true]);

it('blocks writes from an already-open Livewire page after revocation or a non-Google login', function (string $change) {
    $user = $this->actingAsAdmin();
    $response = $this->get(route('filament.admin.resources.admin-accesses.index'))->assertOk();
    $document = Dom\HTMLDocument::createFromString($response->getContent(), LIBXML_NOERROR);
    $snapshot = $document->querySelector('[wire\\:snapshot*="ManageAdminAccess"]')->getAttribute('wire:snapshot');

    Livewire::flushState();

    $mounted = $this->postJson(Livewire::getUpdateUri(), ['components' => [[
        'snapshot' => $snapshot,
        'updates' => [],
        'calls' => [['method' => 'mountAction', 'params' => ['create']]],
    ]]], ['X-Livewire' => 'true'])->assertOk();

    if ($change === 'revocation') {
        AdminAccess::query()->delete();
    }

    if ($change === 'password login') {
        Auth::guard('web')->attempt(['email' => $user->email, 'password' => 'password']);
    }

    Livewire::flushState();

    $result = $this->postJson(Livewire::getUpdateUri(), ['components' => [[
        'snapshot' => $mounted->json('components.0.snapshot'),
        'updates' => ['mountedActions.0.data.email' => 'unauthorized@spatie.be'],
        'calls' => [['method' => 'callMountedAction', 'params' => []]],
    ]]], ['X-Livewire' => 'true']);

    if ($change === 'unchanged') {
        $result->assertOk();
        expect(AdminAccess::query()->where('email', 'unauthorized@spatie.be')->exists())->toBeTrue();

        return;
    }

    $result->assertForbidden();
    expect(AdminAccess::query()->where('email', 'unauthorized@spatie.be')->exists())->toBeFalse();
})->with(['unchanged', 'revocation', 'password login']);
