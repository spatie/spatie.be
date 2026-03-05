@php
    $currentIndex = collect($pages)->search(fn($p) => $p->slug === $page->slug);
    $hasPrevious = $currentIndex > 0;
    $hasNext = $currentIndex < count($pages) - 1;
    $previousPage = $hasPrevious ? $pages[$currentIndex - 1] : null;
    $nextPage = $hasNext ? $pages[$currentIndex + 1] : null;
@endphp


@if ($hasPrevious || $hasNext)
    <div
        class="border border-gray/25 p-6 rounded-md mt-10 flex justify-between items-center bg-link-card-light md:text-lg">
        <div class="w-full grid grid-cols-2 relative text-base">
            <div class="col-span-1">
                @if ($hasPrevious)
                    <a class="flex items-center gap-x-2 text-blue hover:underline gap-x-4"
                        href="/guidelines/{{ $previousPage->slug }}" wire:navigate.hover>
                        <svg class="w-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12">
                            <path fill="#197593"
                                d="m.313 5.623.53.53 4.5 4.5.531.532 1.062-1.062-.53-.53-3.97-3.97 3.968-3.97.532-.53L5.874.062l-.53.532-4.5 4.5-.531.53Z" />
                        </svg>
                        <span class="leading-none mb-px">{{ $previousPage->title }}</span>
                    </a>
                @endif
            </div>

            <div class="absolute left-1/2 top-1/2 w-0.5 h-6 bg-oss-gray-medium -translate-x-1/2 -translate-y-1/2"></div>

            <div class="col-span-1">
                @if ($hasNext)
                    <a class="flex items-center gap-x-2 text-blue hover:underline gap-x-4 w-full justify-end"
                        href="/guidelines/{{ $nextPage->slug }}" wire:navigate.hover>
                        <span class="leading-none mb-px">{{ $nextPage->title }}</span>
                        <svg class="w-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12">
                            <path fill="#197593"
                                d="m6.686 5.623-.53.53-4.5 4.5-.532.532-1.062-1.062.53-.53 3.97-3.97-3.967-3.97-.532-.53L1.123.062l.53.53 4.5 4.5.532.531Z" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
