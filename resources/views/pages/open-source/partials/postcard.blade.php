<div class="illustration is-postcard" style="left: {{ rand(-20, +20) }}px; top: {{ rand(-20, +10) }}px">
    {{ $postcard->getFirstMedia() }}

    <div class="mt-4 links-underline links-black">
        @if($postcard->sender)
            {!! $postcard->sender !!}
        @endif

        @if ($postcard->location)
            <div class="text-sm text-grey">
                <i class="fas fa-map-marker-alt text-grey-lighter"></i> {{ $postcard->location }}
            </div>
        @endif
    </div>
</div>
