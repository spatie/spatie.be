<div class="">
    <a href="{{ action([\App\Http\Controllers\GuidelinesController::class, 'show'], $page->slug) }}" class="flex flex-col justify-center items-center">
        {{ image('guidelines/' . $page->slug . '.png') }}
        <h2 class="text-oss-royal-blue text-bold">{{ $page->title }}</h2>
        <p class="mt-4">{{ $page->description }}</p>
    </a>
</div>
