<x-page title="Music" background="/backgrounds/blogs.jpg">
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Corporate Melodies
            </h1>
            <p class="banner-intro">
                Every month, our team creates a playlist around a theme
            </p>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap">
            <div class="max-w-md grid gap-6">
                @foreach($playlists as $playlist)
                    <div class="flex space-x-8 items-center">
                        <img class="h-40 w-40" src="{{ $playlist->image }}" alt="Playlist cover"/>
                        <div>
                            <span class="font-bold text-xl">{{ $playlist->name }}</span>
                            <div>
                                <a href="{{ $playlist->spotify_url }}">Spotify</a>
                                <span>|</span>
                                <a href="{{ $playlist->apple_music_url }}">Apple Music</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-page>
