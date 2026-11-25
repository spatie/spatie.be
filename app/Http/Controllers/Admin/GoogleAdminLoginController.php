<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminAccess;
use App\Models\User;
use Filament\Facades\Filament;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse as OAuthRedirectResponse;

class GoogleAdminLoginController
{
    public function __invoke(): Response|RedirectResponse
    {
        if (Auth::user()?->canAccessPanel(Filament::getPanel('admin'))) {
            return redirect()->route('filament.admin.pages.dashboard');
        }

        return response()->view('auth.adminLogin')->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function redirect(): OAuthRedirectResponse
    {
        session()->forget('admin_google_login');

        return Socialite::buildProvider(GoogleProvider::class, config('services.google'))
            ->with(['hd' => 'spatie.be', 'prompt' => 'select_account'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            return $this->failure('Google sign-in was cancelled. Try again when you are ready.');
        }

        try {
            $identity = Socialite::buildProvider(GoogleProvider::class, config('services.google'))->user();
            $email = strtolower($identity->getEmail() ?? '');
            $googleId = (string) $identity->getId();

            if (! $identity instanceof GoogleUser || ! str_ends_with($email, '@spatie.be') || blank($googleId) || ! filter_var($identity->getRaw()['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                return $this->failure('Sign in with a verified @spatie.be Google account.');
            }

            $user = DB::transaction(function () use ($email, $googleId, $identity): User {
                $access = AdminAccess::query()->where('email', $email)->lockForUpdate()->first();

                if (! $access) {
                    throw ValidationException::withMessages(['email' => 'This address does not have admin access. Ask an administrator to add you.']);
                }

                if ($access->google_id !== null && $access->google_id !== $googleId) {
                    throw ValidationException::withMessages(['email' => 'This Google account does not match the approved account.']);
                }

                $user = User::query()->where('email', $email)->first();

                $user ??= User::create([
                    'email' => $email,
                    'name' => $identity->getName() ?? strstr($email, '@', true),
                    'password' => bcrypt(Str::random(64)),
                ]);

                $access->update(['google_id' => $googleId]);

                return $user;
            });
        } catch (InvalidStateException) {
            return $this->failure('Your sign-in session expired. Sign in with Google again.');
        } catch (GuzzleException $exception) {
            report($exception);

            return $this->failure('Google sign-in is unavailable. Try again shortly.');
        } catch (ValidationException $exception) {
            return $this->failure($exception->validator->errors()->first());
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        $request->session()->put('admin_google_login', [
            'user_id' => $user->id,
            'email' => strtolower($user->email),
            'google_id' => $googleId,
        ]);

        return redirect()->route('filament.admin.pages.dashboard');
    }

    protected function failure(string $message): RedirectResponse
    {
        session()->forget('admin_google_login');

        return redirect()->route('filament.admin.auth.login')->withErrors(['google' => $message]);
    }
}
