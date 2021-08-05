<x-page
        title="{{ $achievement->title }} | {{ $user->name }}"
        background="/backgrounds/auth.jpg"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $achievement->title }}
            </h1>

            <h2>
                {{ $user->name }}
            </h2>

            {{-- TODO: this should be moved to the proper meta tags --}}
            <a href="{{ $achievement->getOgImageUrl() }}">Show OG image</a>
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
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
            </div>
        </div>
    <section>
</x-page>
