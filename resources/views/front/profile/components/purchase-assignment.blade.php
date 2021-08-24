<?php $theme ??= 'green'; ?>
<div id="{{ $assignment->purchasable->product->slug }}" class="flex flex-col py-6 {{ $theme === 'white' ? 'bg-white shadow-lg' : 'bg-green-lightest line-l line-l-green pr-4 bg-opacity-50' }}">
    <div class="mb-6">
        <a href="{{ route('products.show', $assignment->purchasable->product) }}" class="group block px-4 md:px-6">
            @if (!isset($showImage) || $showImage)
                <div class="-mt-8 pb-8 px-6 md:px-12 transition-transform transform ease-in-out group-hover:-translate-y-2 duration-200">
                    <div class="shadow-md group-hover:shadow-lg">
                        {{ $assignment->purchasable->product->getFirstMedia('product-image') }}
                    </div>
                </div>
            @endif
            <h2 class="title-sm link-black">{{ $assignment->purchasable->product->title }}</h2>
            <p class="text-xs text-gray mt-1">Purchased on {{ $assignment->created_at->format('Y-m-d') }}</p>
        </a>

        @if ($assignment->purchasable->repository_access)
            <div class="mt-6 px-4 md:px-6">
                @if ($assignment->has_repository_access)
                    @foreach(explode(', ', $assignment->purchasable->repository_access) as $repository)
                        <a class="link-blue link-underline" target="_blank" href="https://github.com/{{ $repository }}">
                            Visit {{ $repository }} on GitHub
                        </a>
                    @endforeach
                @else
                    <a class="link-blue link-underline" href="{{ route('github-login') }}">
                        Connect to GitHub to get access to the repository
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{ $slot }}

    @if ($assignment->purchasable->hasMedia('downloads'))
        <div class="mt-4 px-4 md:px-6 text-xs md:text-base">
            @foreach($assignment->purchasable->getMedia('downloads') as $download)
                @php
                    $downloadUrl =  URL::temporarySignedRoute(
                        'purchase.download',
                        now()->addMinutes(30),
                        [$assignment->purchasable->product, $assignment->purchase, $download]
                    );
                @endphp

                <a class="block w-full mt-4" href="{{ $downloadUrl }}" download="download">
                    <button class="truncate w-full cursor-pointer bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-sm border-2 border-transparent justify-center flex items-center px-6 py-2 font-sans-bold text-white transition-bg duration-300 focus:outline-none focus:border-blue-light whitespace-no-wrap">
                        Download {{ $download->getCustomProperty('label') ?? $download->name }}
                    </button>
                </a>
            @endforeach
        </div>
    @endif

    @if ($assignment->purchasable->extra_links)
        <div class="links-button mt-4 px-4 md:px-6">
            {!! $assignment->purchasable->extra_links !!}
        </div>
    @endif
</div>
