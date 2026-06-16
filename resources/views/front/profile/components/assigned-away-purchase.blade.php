@php
    $assignments = $purchase->assignments;
    $typeLabels = \App\Domain\Shop\Enums\PurchasableType::getLabels();
    $productTitles = $assignments
        ->map(fn ($assignment) => $assignment->purchasable->product->title)
        ->unique()
        ->join(', ');
    $purchasableTitles = $assignments
        ->map(fn ($assignment) => $assignment->purchasable->title)
        ->unique()
        ->join(', ');
    $licenseTypes = $assignments
        ->map(fn ($assignment) => $typeLabels[$assignment->purchasable->type] ?? $assignment->purchasable->type)
        ->unique()
        ->join(', ');
    $recipientEmails = $assignments
        ->map(fn ($assignment) => $assignment->user->email)
        ->unique()
        ->join(', ');
    $purchaseDate = $purchase->receipt?->paid_at ?? $purchase->created_at;
@endphp

<div class="grid gap-4 border border-white/10 bg-white/[0.03] px-4 py-5 text-sm md:grid-cols-[1.2fr_1fr_1fr_auto] md:items-center md:px-6">
    <div>
        <div class="font-bold uppercase text-white">{{ $productTitles }}</div>
        <div class="mt-1 text-xs text-oss-gray-dark">{{ $purchasableTitles }}</div>
    </div>
    <div>
        <div class="text-xs font-bold uppercase tracking-wide text-oss-gray-dark">License</div>
        <div>{{ $licenseTypes }}</div>
    </div>
    <div>
        <div class="text-xs font-bold uppercase tracking-wide text-oss-gray-dark">Assigned to</div>
        <div class="break-all">{{ $recipientEmails }}</div>
        @if($purchaseDate)
            <div class="mt-1 text-xs text-oss-gray-dark">Bought on {{ $purchaseDate->format('Y-m-d') }}</div>
        @endif
    </div>
    <div>
        @if($purchase->receipt?->receipt_url)
            <a class="underline hover:text-white" href="{{ $purchase->receipt->receipt_url }}" target="_blank">Download receipt</a>
        @else
            <span class="text-oss-gray-dark">No receipt available</span>
        @endif
    </div>
</div>
