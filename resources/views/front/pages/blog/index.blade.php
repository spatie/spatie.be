<x-page title="Documentation" background="/backgrounds/blog.jpg">
    <!-- @todo replace background -->
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Blog
            </h1>
            <p class="banner-intro">
                The latest insights of the Spatie team.
            </p>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap">
            @foreach ($posts as $post)
                <p class="mt-6">
                    <a class="link link-black" href="{{ $post->url }}" target="_blank" rel="noreferrer noopener">
                        <span class="title-sm">{{ $post->title }}</span>
                        @if($post->short_summary)
                            <br />
                            <span>
                                {{ $post->short_summary }}
                            </span>
                        @endif
                    </a>
                    <br />
                    <span class="text-xs text-gray">
                        {{ $post->created_at->format('M jS Y') }}
                        <span class="char-separator" >•</span>
                        <a class="link-underline link-blue" href="{{ $post->url }}" target="_blank" rel="noreferrer noopener">{{ $post->website }}</a>
                   </span>
                </p>
            @endforeach

            {{ $posts->links() }}
        </div>
    </section>
</x-page>
