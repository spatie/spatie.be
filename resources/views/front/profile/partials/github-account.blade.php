<section class="mb-12 rounded-[20px] bg-oss-purple-extra-dark p-6 md:p-8 shadow-oss-card" aria-labelledby="github-account-heading">
    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between md:gap-8">
        <div class="min-w-0">
            <h2 id="github-account-heading" class="font-bold uppercase text-white">GitHub account</h2>
            @if(auth()->user()->github_username)
                <p class="mt-2">Connected as <strong class="break-words">{{ auth()->user()->github_username }}</strong>.</p>
            @else
                <p class="mt-2">Connect your GitHub account to access repositories included with your purchases.</p>
            @endif
        </div>
        <a class="inline-flex self-start shrink-0 items-center justify-center gap-2 rounded-lg bg-oss-green-pale px-5 py-2.5 text-sm font-bold text-oss-royal-blue transition-opacity hover:opacity-90" href="{{ route('github-login') }}">
            <span class="h-4 w-4 fill-current">{{ app_svg('github') }}</span>
            {{ auth()->user()->github_username ? 'Retry repository access' : 'Connect to GitHub' }}
        </a>
    </div>
    <div class="mt-4 space-y-2 text-sm text-oss-gray">
        <p>Connecting or retrying restores repository access for eligible purchases. Accept any pending GitHub repository invitations to activate access.</p>
        <p>
            Secure two-factor authentication is required: use an authenticator app, passkey, security key, or GitHub Mobile, and remove SMS authentication.
            <a class="underline hover:text-white" href="https://github.com/settings/security" target="_blank" rel="noopener noreferrer">GitHub security settings</a>
        </p>
    </div>
</section>
