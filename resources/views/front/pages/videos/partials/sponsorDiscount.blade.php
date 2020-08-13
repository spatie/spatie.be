@if ($series->purchasables->first()->sponsor_coupon)
    <p class="mt-3 text-xs text-gray">
        As a sponsor, you can get 15$ off with following coupon:
        <span class="mt-2 font-mono opacity-75">{{ $series->purchasables->first()->sponsor_coupon }}</span>
    </p>
@endif
