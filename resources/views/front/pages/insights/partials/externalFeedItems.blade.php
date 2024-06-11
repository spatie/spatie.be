<div>
    <a href="{{ $externalFeedItem->url }}">
        {{ $externalFeedItem->title }}

        <div>
            <time
                datetime="{{ $externalFeedItem->created_at->format('Y-m-d') }}">{{ $externalFeedItem->created_at->format('d F Y') }}</time> {{ $externalFeedItem->website }}

        </div>
    </a>
</div>
