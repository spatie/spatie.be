<div class="">
    <a href="{{ action([\App\Http\Controllers\GuidelinesController::class, 'show'], $page->slug) }}"
        class="flex flex-col justify-center items-center">
        {{ image('guidelines/' . $page->slug . '.png') }}

        <div class="flex flex-col items-center mt-4">
            <h2 class="text-oss-spatie-blue font-bold">{{ $page->title }}</h2>
            <p class="">{{ $page->description }}</p>
        </div>
    </a>
</div>
