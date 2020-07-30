<nav class="sticky top-0 px-4 py-6 bg-white bg-opacity-50 shadow-light rounded-sm markup-lists">
    <h2 class="title-sm text-sm mb-4">{{ $series->title }}</h2>
    <ol class="text-xs grid gap-2 links-blue markup-list-compact">
        @forelse ($series->videos as $video)
            <li class="{{ isset($currentVideo) && $currentVideo->id === $video->id ? "font-sans-bold" : "" }}">
                <a class="block" href="{{ route('videos.show', [$series, $video]) }}">
                    <span class="mr-1">{{ $video->title }}</span>
                    
                    @if($video->display === \App\Models\Enums\VideoDisplayEnum::FREE)
                        <span class="tag tag-green">Free</span>
                    @endif
                    @if($video->display === \App\Models\Enums\VideoDisplayEnum::SPONSORS)
                        <span class="tag tag-pink">Sponsors</span>
                    @endif
                </a>
            </li>
        @empty
            <li>No videos yet! Stay tuned...</li>
        @endforelse
    </ol>
</nav>
