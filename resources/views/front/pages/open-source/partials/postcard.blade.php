<div class="illustration is-postcard" style="left: {{ rand(-20, +20) }}px; top: {{ rand(-20, +10) }}px">
    {{ $postcard->getFirstMedia() }}

    <div class="mt-4 text-xs links-underline links-black leading-tight">
        @if($postcard->sender)
            {!! $postcard->sender !!}
        @endif

        @if ($postcard->location)
            <div class="flex items-baseline text-gray my-2">
                <span>{{ $postcard->location }}</span>
                <span class="icon ml-1 flex-none fill-current text-gray-lighter">{{ svg('icons/fas-map-marker-alt') }}</span>
            </div>
        @endif
    </div>
</div>
