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

                    @if($attachmentUrl = $achievement->getAttachmentUrl())
                        {{-- Should this be a download link or just a new tab? --}}
                        <a href="{{ $attachmentUrl }}" target="_blank" rel="noopener noreferrer">Download your certificate</a>
                    @endif
                </div>
            @endforeach
        </div>
    <section>
</x-page>
