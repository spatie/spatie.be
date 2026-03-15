<?php $theme ??= 'green'; ?>
<div id="{{ $assignment->purchasable->product->slug }}" class="flex flex-col py-6 bg-oss-purple-extra-dark shadow-oss-card rounded-[20px]">
    <div class="mb-6">
        <a href="{{ route('products.show', $assignment->purchasable->product) }}" class="group block px-4 md:px-6">
            @if (!isset($showImage) || $showImage)
                <div class="-mt-8 pb-8 px-6 md:px-12 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                    <div class="shadow-oss-card rounded-[12px] overflow-hidden">
                        {{ $assignment->purchasable->product->getFirstMedia('product-image') }}
                    </div>
                </div>
            @endif
            <h2 class="font-bold uppercase text-white">{{ $assignment->purchasable->product->title }}</h2>
            @if($assignment->purchase->created_at)
                <p class="text-xs text-oss-gray-dark mt-1">Added on {{ $assignment->purchase->created_at->format('Y-m-d') }}</p>
            @endif
        </a>

        @if ($assignment->purchasable->repository_access)
            <div class="mt-6 px-4 md:px-6 text-sm">
                @if ($assignment->has_repository_access)
                    Access has been granted to these repos on GitHub<br/>
                    @foreach(explode(',', $assignment->purchasable->repository_access) as $repository)
                        <a class="underline hover:text-white" target="_blank" href="https://github.com/{{ $repository }}">
                            {{ $repository }}
                        </a><br/>
                    @endforeach
                @else
                    <a class="underline hover:text-white" href="{{ route('github-login') }}">
                        Connect to GitHub to get access to the repository
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{ $slot }}

    @if ($assignment->purchasable->hasMedia('downloads'))
        <div class="px-4 md:px-6 text-xs md:text-base">
            @foreach($assignment->purchasable->getMedia('downloads') as $download)
                @php
                    $downloadUrl =  URL::temporarySignedRoute(
                        'purchase.download',
                        now()->addMinutes(30),
                        [$assignment->purchasable->product, $assignment->purchase, $download]
                    );
                @endphp

                <a class="block w-full mt-4 inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity" href="{{ $downloadUrl }}" download="download">
                    Download {{ $download->getCustomProperty('label') ?? $download->name }}
                </a>
            @endforeach
        </div>
    @endif

    @if ($assignment->purchasable->extra_links)
        <div class="mt-4 px-4 md:px-6 text-sm">
            {!! $assignment->purchasable->extra_links !!}
        </div>
    @endif
</div>
