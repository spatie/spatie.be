<section id="series" class="section">
    <div class="wrap">
        <h2 class="title line-after mb-12">Available series</h2>
    </div>
    <div class="wrap-6 | items-start markup-lists">
        @foreach($allSeries as $series)
            <div class="sm:spanx-3">
                <a href="{{ $series->url }}" class="illustration">
                    {{ image("/video-series/{$series->slug}.jpg") }}
                </a>
            
                <div class="mt-8 line-l">
                    <h2 class="title-sm">
                        <a href="{{ $series->url }}">{{ $series->title }}</a>
                        <div class="title-subtext text-grey">
                            {{ $series->videos()->count() }} free {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}
                            <span class="px-1 rounded-sm bg-green-lightest text-green-dark font-normal text-xs">+ more available</span>
                        </div>
                    </h2>
                    <p class="mt-4">
                        {{ $series->description }}
                    </p>
                    <p class="mt-4">
                        <a class="link-underline link-blue" href="{{ $series->url }}">Watch this series</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>