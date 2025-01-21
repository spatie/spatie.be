<div>
    <a class="group" href="{{ $externalFeedItem->url }}">
        <p class="font-bold text-[20px] group-hover:text-oss-spatie-blue">{{ $externalFeedItem->title }}</p>

        <div class="mt-1 flex gap-4 items-center text-sm">
            <time datetime="{{ $externalFeedItem->created_at->format('Y-m-d') }}">
                {{ $externalFeedItem->created_at->format('d F Y') }}
            </time>
            <span class="text-oss-spatie-blue underline">
                {{ $externalFeedItem->website }}
            </span>
        </div>
    </a>
</div>
