<h2 class="title-sm">
    Latest insights
    <div class="title-subtext text-pink">
        From the team
    </div>
</h2>
@foreach (App\Models\Insight::getLatest() as $insight)
     <p class="mt-4">
        <a class="link link-black" href="{{ $insight->url }}">{{ $insight->title }}</a>
        <br>
        <span class="text-xs text-grey">
            {{ $insight->created_at->format('M jS Y') }}
            <span class="char-separator">•</span>
            <a class="link-underline link-blue" href="{{ $insight->url }}">{{ $insight->website }}</a>
        </span>
    </p>
@endforeach
