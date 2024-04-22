<x-oss-link-card class="border-oss-gray-dark border" light>
    <x-slot:title>
        <a href="{{ action([\App\Http\Controllers\DocsController::class, 'repository'], $repository->slug) }}" wire:navigate class="text-[20px] flex items-center justify-between">
            <span>{{ $repository->slug }}</span>
            <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 9 15"><path d="m8.915 7.5-.706.706-6 6-.71.71L.085 13.5l.706-.706L6.084 7.5.794 2.206.083 1.5 1.5.084l.706.707 6 6 .71.709Z"/></svg>
        </a>
    </x-slot:title>
    <p class="-mt-2 mb-12">{{ $repository->aliases->last()?->slogan }}</p>
    <div class="flex items-center gap-2">
        @foreach($repository->aliases as $alias)
            <span>
                <a class="inline-flex items-center justify-center rounded-full text-[14px] font-bold w-6 h-6 {{ $loop->first ? 'bg-blue text-white' : 'bg-transparent text-oss-royal-blue'}}" href="{{action([\App\Http\Controllers\DocsController::class, 'repository'], [$repository->slug, $alias->slug])}}">
                    {{ $alias->slug }}
                </a>
            </span>
        @endforeach
    </div>
</x-oss-link-card>
