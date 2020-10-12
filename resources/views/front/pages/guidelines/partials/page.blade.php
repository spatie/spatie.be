<div class="line-l">
    <a href="{{ action([\App\Http\Controllers\GuidelinesController::class, 'show'], $page->slug) }}">
        <h2 class="title-sm link-black link-underline">{{ $page->title }}</h2>
        <p class="mt-4">{{ $page->description }}</p>
    </a>
</div>
