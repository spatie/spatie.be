<x-page
        title="Achievements"
        background="/backgrounds/auth.jpg"
>
    {{-- TODO: Add styling --}}
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                My achievements
            </h1>

            <a href="{{ action([\App\Http\Controllers\PublicProfileController::class, 'show'], $user->uuid) }}">
                Share my profile
            </a>
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
            <strong>You've got {{ $user->experience->amount }} XP in total!</strong>

            @foreach ($user->achievements as $achievement)
                <div class="mt-2">
                    @if($imageUrl = $achievement->getImageUrl())
                        <img src="{{ $imageUrl }}" alt="{{ $achievement->title }}">
                    @endif

                    <h3>
                        {{ $achievement->title }}
                    </h3>

                    <p>
                        {{ $achievement->description }}
                    </p>

                    <p>
                        {{ $achievement->created_at->format('Y-m-d') }}
                    </p>

                    <div>
                        @if($certificateUrl = $achievement->getCertificateUrl())
                            {{-- Should this be a download link or just a new tab? --}}
                            <a href="{{ $certificateUrl }}" target="_blank" rel="noopener noreferrer">Download your certificate</a>
                        @endif
                    </div>

                    <div>
                        <a href="{{ $achievement->getShareUrl() }}" target="_blank" rel="noopener noreferrer">Share</a>
                    </div>
                </div>
            @endforeach
        </div>
    <section>

    <section class="section section-group pt-0 mt-4">
        <div class="wrap">
            <strong>Achievements you can still get</strong>

            <ul>
                @foreach ($user->getAvailableAchievements() as $availableAchievement)
                    <li>{{ $availableAchievement->title }}</li>
                @endforeach
            </ul>
        </div>
    <section>
</x-page>
