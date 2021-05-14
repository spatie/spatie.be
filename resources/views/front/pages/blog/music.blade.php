<x-page title="Music" background="/backgrounds/music.jpg">
    @include('front.pages.blog.partials.menu')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Corporate <br>Melodies
            </h1>
            <p class="banner-intro">
                Enjoy the eclectic monthly playlist from our team
            </p>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap">
            <div class="max-w-md grid gap-8">
                @foreach($playlists as $playlist)
                    <div class="flex space-x-8 items-center">
                        <img class="h-40 w-40 bg-white shadow" src="{{ $playlist->image }}" alt="Playlist cover"/>
                        <div>
                            <span class="font-bold text-xl">{{ $playlist->name }}</span>
                            <div>
                                <a class="link link-blue link-underline" href="{{ $playlist->spotify_url }}">Spotify</a>
                                <span class="char-separator">|</span>
                                <a class="link link-blue link-underline" href="{{ $playlist->apple_music_url }}">Apple Music</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-page>
