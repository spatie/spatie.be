<div class="flex items-start gap-4 text-oss-gray-medium">
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
        <p class="font-medium text-[20px] leading-tight mb-1 transition-colors group-hover:text-white">{{ $newsItem->title }}</p>

        <div class="mt-0 flex gap-4 items-center text-sm">
            <time datetime="{{ $newsItem->created_at->format('Y-m-d') }}">
                {{ $newsItem->created_at->format('d F Y') }}
            </time>
            <span class="text-oss-green-pale">
                {{ $newsItem->website }}
            </span>
        </div>
    </a>
</div>
