<p class="mt-4">
    <a class="link link-black" href="{{ $url }}" @unless($website === 'spatie.be') target="_blank" rel="noreferrer noopener" @endunless>
        {{ $title }}
    </a>
    <br>
    <span class="text-xs text-gray">
        {{ $date->format('M jS Y') }}
        <span class="char-separator">•</span>
        <a class="link-underline link-blue" href="{{ $url }}" @unless($website === 'spatie.be') target="_blank" rel="noreferrer noopener" @endunless>
            {{ $website }}
        </a>
    </span>
</p>
