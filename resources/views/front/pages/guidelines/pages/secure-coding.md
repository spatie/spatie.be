---
title: Secure coding
description: Never trust user input.
weight: 4
---

These are the security practices we follow when building Laravel applications and packages. Most of them apply to any Laravel project. For our accounts, devices, servers and how we handle incidents, see [Working securely](/guidelines/security).

## Secrets

- Never commit `.env` files. Share environment values through 1Password
- Only read secrets through `config()`, never through `env()` outside of config files
- When a secret leaks, rotate it immediately. Removing it from the Git history is not enough, assume it has been copied
- When you rotate `APP_KEY`, add the old key to `APP_PREVIOUS_KEYS`, so existing encrypted data and sessions keep working

## Dependencies

Most of the code running in our applications was written by someone else. Treat dependencies as part of your attack surface.

- Always commit `composer.lock` and `package-lock.json`
- Run `composer audit` and `npm audit` in CI, so a vulnerable dependency fails the build
- Use Dependabot to keep dependencies up to date. Configure a `cooldown`, so brand new releases aren't installed the moment they are published. Most malicious releases are discovered within days
- Before adding a new package, check who maintains it, how widely it is used and whether it is still maintained. Fewer dependencies means fewer things that can go wrong
- Pin third-party GitHub Actions to a full commit SHA instead of a tag, and give each workflow the minimum `permissions` it needs
- Never run untrusted code from forks in a `pull_request_target` workflow, it has access to your secrets
- For our packages: use two-factor authentication on Packagist and npm, and only tag releases from the protected `main` branch

## AI

- You're responsible for the code you commit, whoever wrote it. Review AI-generated code like you would review a pull request from a colleague
- Before installing a package an agent suggests, check that it exists and is the package you expect. Attackers register package names that models tend to make up
- Content an agent reads, like issues, pull requests and web pages, can contain hidden instructions. Don't give agents that process untrusted content access to secrets or write access to repositories
- When your application uses an LLM, treat its output as untrusted user input. Escape it before rendering it, never execute it, and authorize every action it triggers in your own code
- Keep LLM API keys on the server, and only send a model the data it needs

## Authentication

Use the authentication scaffolding Laravel provides (starter kits, Fortify, Sanctum) instead of writing your own. When you do write a custom login flow, regenerate the session after logging in to prevent session fixation.

```php
if (! Auth::attempt($credentials)) {
    throw ValidationException::withMessages([
        'email' => __('auth.failed'),
    ]);
}

$request->session()->regenerate();
```

Define password rules once, in the `boot` method of a service provider, and reject passwords that appeared in data leaks.

```php
Password::defaults(fn () => Password::min(12)->uncompromised());
```

```php
'password' => ['required', 'confirmed', Password::defaults()],
```

- Store passwords using the `hashed` cast. Never hash passwords yourself
- In production, `SESSION_SECURE_COOKIE` must be `true`. Keep `http_only` enabled and `same_site` set to `lax` or `strict`
- Admin panels, and accounts with access to customer data, should require two-factor authentication
- Give Sanctum tokens only the abilities they need, and an expiration date. By default, Sanctum tokens never expire

```php
$token = $user->createToken('deploy-script', ['sites:read'], now()->addDays(30));
```

### Internal applications

Internal applications use Google login through [Socialite](https://laravel.com/docs/socialite), restricted to our Google Workspace domain. Passing `hd` to Google only preselects the domain in the account picker. Always check the domain of the returned user as well, otherwise anyone with a Google account can log in.

```php
public function redirect(): RedirectResponse
{
    return Socialite::driver('google')
        ->with(['hd' => 'spatie.be'])
        ->redirect();
}

public function callback(Request $request): RedirectResponse
{
    $googleUser = Socialite::driver('google')->user();

    if (($googleUser->user['hd'] ?? null) !== 'spatie.be') {
        abort(403);
    }

    $user = User::firstWhere('email', $googleUser->getEmail());

    abort_unless($user, 403);

    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->intended();
}
```

Suspending someone's Google account doesn't log them out of sessions that are already active. Keep `SESSION_LIFETIME` short for internal applications, and don't pass `remember: true` to `Auth::login()`.

## Authorization

Every request that reads or changes data must check that the current user is allowed to do so. Use policies, and call them from controllers, form requests and Livewire components.

Never fetch a model by an id from the request without checking who it belongs to. Scope the query to the current user, or authorize it with a policy.

[bad]
```php
public function show(int $siteId): View
{
    $site = Site::findOrFail($siteId);

    return view('sites.show', compact('site'));
}
```
[/bad]

[good]
```php
public function show(Request $request, int $siteId): View
{
    $site = $request->user()->sites()->findOrFail($siteId);

    return view('sites.show', compact('site'));
}
```
[/good]

For nested route parameters, use `scopeBindings()` so Laravel checks that the child belongs to the parent.

```php
Route::get('sites/{site}/checks/{check}', [SiteChecksController::class, 'show'])->scopeBindings();
```

Public properties of Livewire components can be changed by the user in the browser. Lock properties that hold ids, and authorize again in every action.

```php
use Livewire\Attributes\Locked;
use Livewire\Component;

class EditSite extends Component
{
    #[Locked]
    public int $siteId;

    public string $name = '';

    public function save(): void
    {
        $site = Site::findOrFail($this->siteId);

        $this->authorize('update', $site);

        $site->update(['name' => $this->name]);
    }
}
```

In production, Filament panels are only accessible to users that pass `canAccessPanel()`. Always implement the `FilamentUser` interface on your user model.

Add tests that prove unauthorized users can't access or change data.

```php
it('does not allow users to view sites of other users', function () {
    $site = Site::factory()->create();

    $this
        ->actingAs(User::factory()->create())
        ->get(route('sites.show', $site))
        ->assertForbidden();
});
```

## Mass assignment

When a model uses `$guarded = []`, every attribute can be mass assigned. That's convenient, but it means you must never pass unvalidated input to `create`, `update` or `fill`. Otherwise a user can set attributes like `is_admin` or `team_id` by adding them to the request.

[bad]
```php
$site->update($request->all());
```
[/bad]

[good]
```php
$site->update($request->validated());
```
[/good]

## Input and output

- Blade's `{{ }}` escapes output. Only use `{!! !!}` for content you fully control. The same goes for `v-html` in Vue and `x-html` in Alpine
- When rendering markdown written by users, strip HTML and unsafe links

```php
$html = Str::markdown($comment->body, [
    'html_input' => 'strip',
    'allow_unsafe_links' => false,
]);
```

- Always use bindings in raw queries

[bad]
```php
DB::select("select * from users where email = '{$email}'");
```
[/bad]

[good]
```php
DB::select('select * from users where email = ?', [$email]);
```
[/good]

- Column names can't be bound. Never pass user input to `orderBy`, `groupBy` or `select` without checking it against a list of allowed values

```php
$request->validate([
    'sort' => ['nullable', Rule::in(['name', 'created_at'])],
]);

$sites = Site::orderBy($request->input('sort', 'name'))->get();
```

- Routes that change data must use `POST`, `PUT`, `PATCH` or `DELETE`, never `GET`. Laravel only checks CSRF tokens on those methods
- Don't exclude routes from CSRF protection, unless they are verified in another way, like a webhook signature
- Verify the signature of incoming webhooks. [laravel-webhook-client](https://github.com/spatie/laravel-webhook-client) does this for you
- When your application fetches a URL provided by a user, make sure it can't be used to reach internal services, like `localhost`, private IP ranges or cloud metadata endpoints

## File uploads

- Validate the file type and size of every upload
- Never use the original file name or extension provided by the client. Let Laravel generate a name
- Store private files on a disk that isn't publicly accessible, and serve them through a temporary signed URL
- SVG files can contain JavaScript. Don't accept SVG uploads, unless you sanitize them or only serve them from a separate domain

[bad]
```php
$request->file('invoice')->storeAs(
    'invoices',
    $request->file('invoice')->getClientOriginalName(),
    'public',
);
```
[/bad]

[good]
```php
$request->validate([
    'invoice' => ['required', File::types(['pdf'])->max(10 * 1024)],
]);

$path = $request->file('invoice')->store('invoices', 'local');
```
[/good]

```php
$url = URL::temporarySignedRoute('invoices.download', now()->addMinutes(5), ['invoice' => $invoice]);
```

## Rate limiting

Add rate limiting to every route that can be abused: login, registration, password resets, contact forms and API endpoints. Define custom limiters in a service provider.

```php
RateLimiter::for('contactMessages', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});
```

```php
Route::post('contact', [ContactMessagesController::class, 'store'])->middleware('throttle:contactMessages');
```

For public forms, also consider [laravel-honeypot](https://github.com/spatie/laravel-honeypot) to stop spam bots.

## Security headers

Every application should send these headers. They can be added in the web server configuration or in a middleware.

```
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
```

Use a Content Security Policy to limit where scripts, styles and other resources can be loaded from. [laravel-csp](https://github.com/spatie/laravel-csp) makes this easy. Some tips:

- Start with `Content-Security-Policy-Report-Only`, check the reported violations, and only enforce the policy when there are none left
- Add `frame-ancestors 'self'` to prevent other sites from embedding yours in an iframe
- Call `Vite::useCspNonce()` so the scripts and styles Vite generates get a nonce
- Alpine and Livewire evaluate expressions at runtime. Check their CSP documentation before enforcing a policy on an application that uses them

## Logging sensitive data

Logs, error trackers and queued job payloads are often stored longer, and are accessible to more people, than the database itself.

- Never log passwords, tokens, API keys or full request payloads
- Mark sensitive parameters with `#[SensitiveParameter]`, so their values are left out of stack traces

```php
use SensitiveParameter;

public function connect(string $username, #[SensitiveParameter] string $password): void
```

- Add sensitive attributes to `$hidden` on the model, so they are never included when the model is serialized
- Configure Flare to censor sensitive request fields
- Queued jobs that contain sensitive data should implement `ShouldBeEncrypted`
- Encrypt API keys and other secrets stored in the database with the `encrypted` cast

## Production configuration

- `APP_ENV` must be `production` and `APP_DEBUG` must be `false`. A debug error page shows your environment variables to anyone
- Protect dashboards like Horizon, Telescope and Pulse with a gate
- Only install development tools, like Debugbar, as a dev dependency
- All traffic must be served over HTTPS. Redirect HTTP to HTTPS

## Resources

- [OWASP Top 10](https://owasp.org/Top10/2025/)
- [OWASP Laravel Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Laravel_Cheat_Sheet.html)
