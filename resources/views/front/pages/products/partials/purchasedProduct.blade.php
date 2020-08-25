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

    <div class="cell-r flex justify-end space-x-4">
    @if ($purchasable->series->count())
            <a href="{{ route('series.show', $purchasable->series->first()) }}">
                <x-button>
                    Watch videos
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
                Download {{$download->name}}
            </x-button>
        </a>
    @endforeach
    
    </div>
</div>
