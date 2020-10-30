<h2 class="title-sm">
    Latest insights
    <span class="title-subtext text-pink-dark block">
        From the team
    </span>
</h2>
@foreach ($insights as $insight)
     <p class="mt-4">
        <a class="link link-black" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->title }}</a>
        <br>
        <span class="text-xs text-gray">
            {{ $insight->created_at->format('M jS Y') }}
            <span class="char-separator" >•</span>
            <a class="link-underline link-blue" href="{{ $insight->url }}" target="_blank" rel="noreferrer noopener">{{ $insight->website }}</a>
        </span>
    </p>
@endforeach
