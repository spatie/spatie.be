<div>
    <a href="{{ $insight->url }}">
        {{ $insight->title }}

        <div>
            <time
                datetime="{{ $post->date->format('Y-m-d') }}">{{ $post->date->format('d F Y') }}</time> {{ $insight->website }}

        </div>
    </a>
</div>
