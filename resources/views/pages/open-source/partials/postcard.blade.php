<div class="illustration is-postcard" style="left: {{ rand(-20, +20) }}px; top: {{ rand(-20, +10) }}px">
    {{ $postcard->getFirstMedia() }}

    <div class="mt-4 text-sm links-underline links-black">
        @if($postcard->sender)
            {!! $postcard->sender !!}
        @endif

        @if ($postcard->location)
            <div class="flex items-start text-xs text-grey">
                <i class="fas flex-none fa-map-marker-alt text-grey-lighter"></i>
                <span class="ml-2">{{ $postcard->location }}</span>
            </div>
        @endif
    </div>
</div>
