<div class="flex items-start gap-4">
    @if($newsItem->avatar_url)
        <img
            src="{{ $newsItem->avatar_url }}"
            alt="{{ $newsItem->avatar_alt }}"
            class="mt-1 size-8 sm:size-10 shrink-0 rounded-full object-cover [image-rendering:pixelated]"
        >
    @else
        <span aria-hidden="true" class="mt-1 size-8 sm:size-10 shrink-0 rounded-full border border-white/20 bg-white/5"></span>
    @endif
    <a
        class="group block flex-1"
        href="{{ $newsItem->url }}"
        @if($newsItem->is_external)
            target="_blank"
            rel="noreferrer noopener"
        @else
            wire:navigate.hover
        @endif
    >
        <p class="font-bold text-[20px] leading-tight mb-1 group-hover:text-oss-spatie-blue">{{ $newsItem->title }}</p>

        <div class="mt-0 flex gap-4 items-center text-sm">
            <time datetime="{{ $newsItem->created_at->format('Y-m-d') }}">
                {{ $newsItem->created_at->format('d F Y') }}
            </time>
            <span class="text-oss-spatie-blue underline">
                {{ $newsItem->website }}
            </span>
        </div>
    </a>
</div>
