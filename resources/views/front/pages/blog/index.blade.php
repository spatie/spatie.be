<x-page title="Blog" background="/backgrounds/blogs.jpg">
    <!-- @todo replace background -->
    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Latest insights 
                <br>of the team
            </h1>
            <p class="banner-intro">
                A collection of articles on our personal blogs
            </p>
        </div>
    </section>

    <section class="section section-group">
        <div class="wrap">
            <div class="max-w-md grid gap-6">
                @foreach ($posts as $post)
                    <p class="">
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
                <div class="mt-12">
                {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>
</x-page>
