<div class="grid-item mb-4 w-[300px] lg:w-[318px] border border-oss-gray-extra-dark rounded-[20px] p-9">
    <div class="rounded-[10px] overflow-hidden">
        {{ $postcard->getFirstMedia() }}
    </div>

    <div class="mt-6 text-[16px]">
        @if($postcard->sender)
            {!! $postcard->sender !!}
        @endif

        @if ($postcard->location)
            <div class="flex items-baseline text-oss-gray-dark">
                <span>{{ $postcard->location }}</span>
                <span class="icon ml-3 flex-none fill-current">{{ app_svg('icons/fas-map-marker-alt') }}</span>
            </div>
        @endif
    </div>
</div>
