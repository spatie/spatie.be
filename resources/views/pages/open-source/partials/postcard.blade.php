<div class="illustration is-postcard" style="left: {{ rand(-20, +20) }}px; top: {{ rand(-20, +10) }}px">
    {{ $postcard->getFirstMedia() }}

    <div class="mt-4 text-xs links-underline links-black leading-tight">
        @if($postcard->sender)
            {!! $postcard->sender !!}
        @endif

        @if ($postcard->location)
            <div class="flex items-baseline text-grey my-2">
                <span>{{ $postcard->location }}</span>
                <i class="ml-1 flex-none fas fa-map-marker-alt text-grey-lighter"></i>
            </div>
        @endif
    </div>
</div>
