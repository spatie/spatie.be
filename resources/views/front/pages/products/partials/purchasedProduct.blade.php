@php
    /** @var \App\Models\Purchase $purchase */
    $purchasable = $purchase->purchasable;
@endphp

<div class="cells grid-cols-2">
    <div class="cell-l">
        <div class="text-xs text-gray">
            {{ request()->user()->email }}
            <span class="char-searator mx-1">•</span>
            Purchased on {{ $purchase->created_at->format('Y-m-d') }}
        </div>
    </div>

    <div class="cell-r grid gap-4 justify-start md:grid-flow-col md:justify-end">
        @if ($purchasable->series->count())
                <a href="{{ route('series.show', $purchasable->series->first()) }}">
                    <x-button>
                        Videos
                    </x-button>
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

            <a class="link" download="download" href="{{ $downloadUrl }}">
                <x-button>
                    Download {{ $download->getCustomProperty('label') ?? $download->name }}
                </x-button>
            </a>
        @endforeach

        @if ($purchasable->repository_access)
            @if ($purchase->has_repository_access)
                    <a href="https://github.com/{{ $purchasable->repository_access }}">
                        <x-button>
                            Repository
                        </x-button>
                    </a>

                @else
                    <a class="link-blue link-underline" href="{{ route('github-login') }}">
                        Connect to GitHub to access repo
                    </a>
                @endif
            @endif
    </div>
</div>
