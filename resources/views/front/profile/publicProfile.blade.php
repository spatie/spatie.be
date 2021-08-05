<x-page
        title="{{ $user->name }}"
        background="/backgrounds/auth.jpg"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ $user->name }}
            </h1>
        </div>
    </section>

    <section class="section section-group pt-0">
        <div class="wrap">
            <strong>{{ $user->name }} got {{ $user->experience->amount }} XP in total!</strong>

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
                </div>
            @endforeach
        </div>
    <section>
</x-page>
