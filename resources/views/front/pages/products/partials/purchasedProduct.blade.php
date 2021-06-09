@php
    /** @var \App\Models\Purchase $purchase */
    $purchasable = $purchase->purchasable;
@endphp

<div class="cells">
    <div class="cell-l">
        {!! $purchasable->getting_started_description ?? '' !!}
        <div>
            @if ($purchasable->getting_started_url)
                <div>
                    <a class="link-blue link-underline" href="{{ $purchasable->getting_started_url }}">
                        Getting started
                    </a>
                </div>
            @endif

            @foreach($purchasable->getMedia('downloads') as $download)
                @php
                    $downloadUrl =  URL::temporarySignedRoute(
                        'purchase.download',
                        now()->addMinutes(30),
                        [$purchasable->product, $purchase, $download]
                    );
                @endphp

                <div>
                    <a class="link-blue link-underline" download="download" href="{{ $downloadUrl }}">
                        Download {{ $download->getCustomProperty('label') ?? $download->name }}
                    </a>
                </div>
            @endforeach

            @if ($purchasable->series->count())
                <div>
                    <a class="link-blue link-underline"
                       href="{{ route('series.show', $purchasable->series->first()) }}">
                        Watch course videos
                    </a>
                </div>
            @endif

            @if ($purchasable->repository_access)
                <div>
                    @if ($purchase->has_repository_access)
                        <a class="link-blue link-underline"
                           href="https://github.com/{{ $purchasable->repository_access }}">
                            Visit {{ $purchasable->repository_access }} on GitHub
                        </a>

                    @else
                        <a class="link-blue link-underline" href="{{ route('github-login') }}">
                            Connect to GitHub to get access to the {{ $purchasable->repository_access }} repo
                        </a>
                    @endif
                </div>
            @endif

                @if ($purchasable->extra_links)
                    {!! $purchasable->extra_links !!}
                @endif


        </div>
        <div class="mt-2 text-xs text-gray">
            {{ request()->user()->email }}
            <span class="char-searator mx-1">•</span>
            Purchased on {{ $purchase->created_at->format('Y-m-d') }}
        </div>

    </div>
</div>
