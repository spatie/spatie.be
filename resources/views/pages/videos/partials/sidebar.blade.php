<nav class="markup-lists">
    <h2 class="title-sm text-sm text-grey mb-4">{{ $series->title }}</h2>
    <ol class="text-xs">
        @forelse ($series->videos as $video)
            <li style="padding-left:2em" class="{{ isset($currentVideo) && $currentVideo->id === $video->id ? "font-sans-bold" : "" }}">
                <a href="{{ route('videos.show', [$series, $video]) }}">
                    {{ $video->title }}
                </a>
            </li>
        @empty
            <li>No videos yet! Stay tuned...</li>
        @endforelse
    </ol>
</nav>
