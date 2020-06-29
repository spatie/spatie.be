<nav class="markup-lists">
    <h2 class="title-sm text-sm text-white opacity-50 mb-4">{{ $series->title }}</h2>
    <ol class="text-xs grid gap-2 links-underline links-white markup-list-compact">
        @forelse ($series->videos as $video)
            <li class="{{ isset($currentVideo) && $currentVideo->id === $video->id ? "font-sans-bold" : "" }}">
                <a class="block" href="{{ route('videos.show', [$series, $video]) }}">
                    {{ $video->title }}
                    @if($video->display === \App\Models\Enums\VideoDisplayEnum::FREE)
                        <span class="ml-1 bg-green-lightest text-green text-xs font-normal py-1 px-2 rounded-full">Free</span>
                    @endif
                    @if($video->display === \App\Models\Enums\VideoDisplayEnum::SPONSORS)
                        <span class="ml-1 bg-pink-lightest text-pink text-xs font-normal py-1 px-2 rounded-full">Sponsors</span>
                    @endif
                </a>
            </li>
        @empty
            <li>No videos yet! Stay tuned...</li>
        @endforelse
    </ol>
</nav>
