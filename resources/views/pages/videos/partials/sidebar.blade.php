<nav class="markup-lists">
    <h2 class="title-sm text-sm text-white opacity-50 mb-4">{{ $series->title }}</h2>
    <ol class="text-xs grid gap-2 links-underline links-white">
        @forelse ($series->videos as $video)
            <li style="padding-left:2em" class="{{ isset($currentVideo) && $currentVideo->id === $video->id ? "font-sans-bold" : "" }}">
                <a class="block" href="{{ route('videos.show', [$series, $video]) }}">
                    {{ $video->title }}
                </a>
            </li>
        @empty
            <li>No videos yet! Stay tuned...</li>
        @endforelse
    </ol>
</nav>
