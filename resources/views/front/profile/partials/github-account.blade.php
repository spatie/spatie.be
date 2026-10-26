@php
    $statuses = collect($repositoryAccessStatuses);
    $hasMissingAccess = $statuses->contains(\App\Services\GitHub\RepositoryAccessStatus::Missing);
    $hasUnknownAccess = $statuses->contains(\App\Services\GitHub\RepositoryAccessStatus::Unknown);
    $pendingRepositories = $statuses->filter(fn ($status) => $status === \App\Services\GitHub\RepositoryAccessStatus::Pending);
@endphp
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
        @if(! auth()->user()->github_username || $hasMissingAccess || $hasUnknownAccess)
            <a class="inline-flex self-start shrink-0 items-center justify-center gap-2 rounded-lg bg-oss-green-pale px-5 py-2.5 text-sm font-bold text-oss-royal-blue transition-opacity hover:opacity-90" href="{{ route('github-login') }}">
                <span class="h-4 w-4 fill-current">{{ app_svg('github') }}</span>
                {{ auth()->user()->github_username ? 'Restore repository access' : 'Connect to GitHub' }}
            </a>
        @endif
    </div>
    <div class="mt-4 space-y-2 text-sm text-oss-gray">
        @if($statuses->isNotEmpty() && $statuses->every(fn ($status) => $status === \App\Services\GitHub\RepositoryAccessStatus::Granted))
            <p>You have access to all GitHub repositories included with your eligible purchases.</p>
        @elseif($hasUnknownAccess)
            <p>We could not verify all of your GitHub repository access right now. You can try restoring access or check again shortly.</p>
        @elseif($hasMissingAccess || ! auth()->user()->github_username)
            <p>Connecting or restoring access grants access to repositories included with eligible purchases.</p>
        @endif
        @if($pendingRepositories->isNotEmpty())
            <p>Accept your pending GitHub repository invitations to activate access:</p>
            <ul class="list-disc pl-5">
                @foreach($pendingRepositories as $repository => $status)
                    <li><a class="underline hover:text-white" href="https://github.com/{{ $repository }}/invitations" target="_blank" rel="noopener noreferrer">Accept invitation to {{ $repository }}</a></li>
                @endforeach
            </ul>
        @endif
        @if(! auth()->user()->github_username || $hasMissingAccess || $hasUnknownAccess || $pendingRepositories->isNotEmpty())
            <p>
                Secure two-factor authentication is required: use an authenticator app, passkey, security key, or GitHub Mobile, and remove SMS authentication.
                <a class="underline hover:text-white" href="https://github.com/settings/security" target="_blank" rel="noopener noreferrer">GitHub security settings</a>
            </p>
        @endif
    </div>
</section>
