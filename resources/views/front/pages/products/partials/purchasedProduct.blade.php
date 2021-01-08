@php
    /** @var \App\Models\Purchase $purchase */
    $purchasable = $purchase->purchasable;
@endphp

<div class="cells">
    <div class="cell-l">
        {!! $purchasable->getting_started_description ?? '' !!}
        <div class="grid grid-flow-col gap-4 justify-start">
            @if ($purchasable->getting_started_url)
                <a class="link-blue link-underline" href="{{ $purchasable->getting_started_url }}">
                    Getting started
                </a>
            @endif

            @if ($purchasable->series->count())
                <a class="link-blue link-underline" href="{{ route('series.show', $purchasable->series->first()) }}">
                    Videos
                </a>
            @endif

            @foreach($purchasable->getMedia('downloads') as $download)
                    @php
                        $downloadUrl =  URL::temporarySignedRoute(
                            'purchase.download',
                            now()->addMinutes(30),
                            [$purchasable->product, $purchase, $download]
                        );
                    @endphp

                <a class="link-blue link-underline" download="download" href="{{ $downloadUrl }}">
                    Download {{ $download->getCustomProperty('label') ?? $download->name }}
                </a>
            @endforeach

            @if ($purchasable->repository_access)
                @if ($purchase->has_repository_access)
                        <a class="link-blue link-underline" href="https://github.com/{{ $purchasable->repository_access }}">
                            Repository
                        </a>

                    @else
                        <a class="link-blue link-underline" href="{{ route('github-login') }}">
                            Connect to GitHub to access repo
                        </a>
                    @endif
                @endif
        </div>
        <div class="mt-2 text-xs text-gray">
            {{ request()->user()->email }}
            <span class="char-searator mx-1">•</span>
            Purchased on {{ $purchase->created_at->format('Y-m-d') }}
        </div>

    </div>
</div>
