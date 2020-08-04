<div class="line-l">
    <a href="{{ action([\App\Http\Front\Controllers\DocsController::class, 'repository'], $repository->slug) }}">
        <h2 class="title-sm link-black link-underline">{{ $repository->slug }}</h2>
        <p class="mt-4">{{ $repository->aliases->last()->slogan }}</p>
        <div class="text-xs mt-4 text-gray">
            @foreach($repository->aliases as $alias)
                <span>
                    <a href="{{action([\App\Http\Front\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug])}}">
                        {{ $alias->slug }}
                    </a>
                    @if(! $loop->last)
                        <span class="char-separator">•</span>
                    @endif
                </span>
            @endforeach
        </div>
    </a>
</div>
