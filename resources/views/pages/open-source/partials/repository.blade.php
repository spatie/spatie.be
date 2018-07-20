<div class="cell-l">
    <div>
        <a class="font-sans-bold link-underline link-blue" href="{{ $repository->url }}">{{ $repository->name }}</a>
    </div>
    <div class="text-xs mt-2 text-grey">
        @if($repository->language)
            <span class="font-bold">{{ $repository->language }}</span>
            <span class="char-separator">•</span>
        @endif
        @if ($repository->downloads > 0)
            {{ $repository->formatted_downloads }} <i class="fal fa-arrow-to-bottom"></i>
            <span class="char-separator">•</span>
        @endif
        {{ $repository->formatted_stars }} <i class="fal fa-star"></i>

        @if ($repository->hasIssues())
            <a href="{{ $repository->issues_url }}" class="bg-green-lightest text-green-dark rounded-full px-2 ml-2">easy
                issues</a>
        @endif

        @if ($repository->new)
            <span class="bg-pink-lightest text-pink-dark rounded-full px-2 ml-2">new</span>
        @endif
    </div>
</div>
<div class="cell">
    {{ $repository->description }}
    <div class="text-xs mt-2 text-grey">

        @foreach($repository->topics as $topic)
            {{ $topic }}

            @if(! $loop->last)
                <span class="char-separator">•</span>
            @endif
        @endforeach
    </div>
</div>
<div class="cell-r grid-text-right">
    @if ($repository->documentation_url)
        <a href="{{ $repository->documentation_url }}" class="link-underline link-grey text-xs">Documentation</a>
        <br>
    @endif

    @if($repository->blogpost_url)
        <a href="{{ $repository->blogpost_url }}" class="link-underline link-grey text-xs">Blogpost</a>
    @endif
</div>
