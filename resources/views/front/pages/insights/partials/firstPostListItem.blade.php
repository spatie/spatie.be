<article>
    Last article

    <div>
        <time datetime="{{ $post->date->format('Y-m-d') }}">{{ $post->date->format('d F Y') }}</time>
    </div>

    {{ $post->title }}

    <p>{{ htmlspecialchars_decode(strip_tags($post->summary)) }}</p>

</article>
