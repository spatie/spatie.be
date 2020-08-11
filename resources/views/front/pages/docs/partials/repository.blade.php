<div class="line-l">
        <a href="{{ action([\App\Http\Controllers\DocsController::class, 'repository'], $repository->slug) }}">
            <h2 class="title-sm link-black link-underline">{{ $repository->slug }}</h2>
            <p class="mt-4">{{ $repository->aliases->last()->slogan }}</p>
        </a>
        <div class="mt-2 text-xs grid grid-flow-col gap-2 justify-start items-center">
            @foreach($repository->aliases as $alias)
                <span>
                    <a class="inline-flex items-center justify-center rounded-full w-6 h-6 bg-opacity-50 hover:bg-opacity-100 {{ $loop->first ? 'bg-blue-lightest text-blue font-bold' : 'bg-gray-lightest text-gray-dark'}}" href="{{action([\App\Http\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug])}}">
                        {{ $alias->slug }}
                    </a>
                </span>
            @endforeach
        </div>
    
</div>
