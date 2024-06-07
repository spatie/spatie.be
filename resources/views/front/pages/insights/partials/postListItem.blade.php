<article>
    <div>
        <h3>
            <a href="{{ route('insights.show', $post->slug) }}">
                <span></span>
                {{ $post->title }}
            </a>
        </h3>
        <p>{{ htmlspecialchars_decode(strip_tags($post->summary)) }}</p>
    </div>
    @isset($post->date)
        <div>
            <time datetime="{{ $post->date->format('Y-m-d') }}">{{ $post->date->format('d F Y') }}</time>
        </div>
    @endisset
</article>
