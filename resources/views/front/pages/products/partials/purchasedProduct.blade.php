@php
    /** @var \App\Models\Purchase $purchase */
@endphp

<div class="cells grid-cols-2">
    <div class="cell-l">
        <div class="text-xs text-gray">
            {{ request()->user()->email }}
            <span class="char-searator mx-1">•</span>
            Purchases at {{ $purchase->created_at->format('d/m/Y') }}
        </div>
        <div>
            @foreach($purchase->purchasable->getMedia('downloads') as $download)
                {{ $download->id }}
            @endforeach
        </div>
    </div>

    <span  class="cell-r flex justify-end space-x-4">
        <x-button>
            Watch videos
        </x-button>
    </span>
</div>
