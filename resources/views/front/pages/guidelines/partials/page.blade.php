<div class="sm:w-[calc(33.333%-1rem)]">
    <a href="{{ action([\App\Http\Controllers\GuidelinesController::class, 'show'], $page->slug) }}"
        class="flex flex-col justify-center items-center text-center">
        @if(file_exists(resource_path('images/guidelines/' . $page->slug . '.svg')))
            <div class="w-full max-w-[280px] mx-auto [&>svg]:w-full [&>svg]:h-auto">
                {!! file_get_contents(resource_path('images/guidelines/' . $page->slug . '.svg')) !!}
            </div>
        @endif

        <div class="flex flex-col items-center mt-4">
            <h2 class="text-oss-spatie-blue font-bold">{{ $page->title }}</h2>
            <p class="max-w-[20ch]">{{ $page->description }}</p>
        </div>
    </a>
</div>
