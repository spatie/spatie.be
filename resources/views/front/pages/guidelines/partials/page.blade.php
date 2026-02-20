<div class="">
    <a href="{{ action([\App\Http\Controllers\GuidelinesController::class, 'show'], $page->slug) }}"
        class="flex flex-col justify-center items-center">
        @if(file_exists(resource_path('images/guidelines/' . $page->slug . '.svg')))
            {!! file_get_contents(resource_path('images/guidelines/' . $page->slug . '.svg')) !!}
        @endif

        <div class="flex flex-col items-center mt-4">
            <h2 class="text-oss-spatie-blue font-bold">{{ $page->title }}</h2>
            <p class="text-center max-w-[20ch]">{{ $page->description }}</p>
        </div>
    </a>
</div>
