<div>
    <a class="group" href="{{ $externalFeedItem->url }}">
        <span class="font-bold text-[20px] group-hover:text-oss-spatie-blue">{{ $externalFeedItem->title }}</span>

        <div class="mt-3 flex gap-4 items-center text-sm">
            <time datetime="{{ $externalFeedItem->created_at->format('Y-m-d') }}">
                {{ $externalFeedItem->created_at->format('d F Y') }}
            </time>
            <span class="text-oss-spatie-blue underline">
                {{ $externalFeedItem->website }}
            </span>
        </div>
    </a>
</div>
