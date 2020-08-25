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
        <div>
            <ul>
                @foreach($purchasable->getMedia('downloads') as $download)
                    @php
                        $downloadUrl =  URL::temporarySignedRoute(
                            'purchase.download',
                            now()->addMinutes(30),
                            [$purchasable->product, $purchase, $download]
                        );
                    @endphp

                    <li>
                        <a download="download" href="{{ $downloadUrl }}">
                            Download {{$download->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if ($purchasable->series->count())
        <div class="cell-r flex justify-end space-x-4">
            <a href="{{ route('series.show', $purchasable->series->first()) }}">
                <x-button>
                    Watch videos
                </x-button>
            </a>
        </div>
    @endif
</div>
