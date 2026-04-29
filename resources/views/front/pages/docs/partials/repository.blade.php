@use(App\Http\Controllers\DocsController)
@use(Illuminate\Support\Number)
@use(Illuminate\Support\Str)
@php
    $slogan = $repository->aliases->last()?->slogan;
    $stars = $repository->stars;
    $starsLabel = $stars === null ? null : Str::lower(Number::abbreviate($stars, maxPrecision: 1));
    $haystack = Str::lower(implode(' ', array_filter([$repository->slug, $slogan, $repository->category])));
@endphp
<a
    href="{{ action([DocsController::class, 'repository'], $repository->slug) }}"
    wire:navigate
    class="group items-center gap-4 py-3 -mx-3 px-3 rounded border-b border-oss-gray-medium/70 hover:bg-white/60 transition break-inside-avoid"
    :class="!query || @js($haystack).includes(query.toLowerCase()) ? 'flex' : 'hidden'"
>
    <div class="flex-1 min-w-0">
        <div class="flex flex-col sm:flex-row sm:items-baseline sm:gap-3">
            <h3 class="text-[17px] font-semibold text-oss-royal-blue truncate">{{ $repository->slug }}</h3>
            @if ($slogan)
                <p class="text-[14px] text-oss-gray-extra-dark truncate">{{ $slogan }}</p>
            @endif
        </div>
    </div>

    @if ($starsLabel)
        <span class="shrink-0 inline-flex items-center gap-1 text-[12px] font-semibold text-oss-royal-blue/70 tabular-nums">
            <svg viewBox="0 0 24 24" class="w-3.5 h-3.5" fill="currentColor" aria-hidden="true">
                <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
            {{ $starsLabel }}
        </span>
    @endif

    <svg class="w-2 fill-current text-oss-royal-blue/40 group-hover:text-oss-royal-blue shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 9 15">
        <path d="m8.915 7.5-.706.706-6 6-.71.71L.085 13.5l.706-.706L6.084 7.5.794 2.206.083 1.5 1.5.084l.706.707 6 6 .71.709Z"/>
    </svg>
</a>
