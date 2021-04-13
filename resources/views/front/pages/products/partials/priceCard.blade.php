@php
    $priceWithoutDiscount = $purchasable->getPriceWithoutDiscountForCurrentRequest();
    $price = $purchasable->getPriceForCurrentRequest()
@endphp
<div
    class="{{ isset($first) && $first ? 'mb-12 py-6 md:-mt-8 md:py-10 md:z-10' : 'mb-8 py-6' }} md:mb-0 md:mx-2 max-w-md flex flex-col bg-white shadow-lg px-8"
    style="bottom: {{ isset($first) && $first ? '-2rem' : '-1rem' }}">
    <h2 class="flex-0 flex items-center font-bold {{ isset($first) && $first ? 'text-2xl' : 'text-lg'}} mb-4 min-h-10">
        {{ $purchasable->title }}
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        @if ($purchasable->originalPurchasable)
            {!! $purchasable->originalPurchasable->formattedDescription !!}
        @else
            {!! $purchasable->formattedDescription !!}
        @endif
    </div>

    @if ($purchasable->hasActiveDiscount())
        @if(optional(current_user())->enjoysExtraDiscountOnNextPurchase())
            <div class="-mx-6 px-2 py-3 mt-4 bg-green-lightest text-black text-sm text-center">
                Personal discount included!
            </div>
        @endif

        @if(\App\Models\Referrer::activeReferrerGrantsDiscount($purchasable))
            <div class="-mx-6 px-2 py-3 mt-4 bg-green-lightest text-black text-sm text-center">
                Extra discount included!
            </div>
        @endif

        <div class="-mx-6 px-2 py-3 bg-green-lightest mt-4 text-black text-sm text-center">
            @if ($purchasable->discount_name)
                <span>{{ $purchasable->discount_name }} <span class="char-separator">•</span> </span>
            @endif
            Now <span class="font-semibold">{{ $purchasable->displayableDiscountPercentage() }}%</span> off
            @if(optional(current_user())->enjoysExtraDiscountOnNextPurchase())
                for you
            @endif

            @if(optional($purchasable->currentDiscountPercentageExpiresAt())->isFuture())
                <div
                    class="mt-1 text-green-dark text-xs"
                    style="font-variant-numeric:tabular-nums">
                    <x-countdown :expires="$purchasable->currentDiscountPercentageExpiresAt()">
                        <span><span
                                x-text="timer.days"
                                class="font-mono font-semibold">{{ $component->days() }}</span> <span>days</span></span>
                        <span><span
                                x-text="timer.hours"
                                class="font-mono font-semibold">{{ $component->hours() }}</span> <span>hours</span></span>
                        <span><span
                                x-text="timer.minutes"
                                class="font-mono font-semibold">{{ $component->minutes() }}</span> <span>minutes</span></span>
                        <span><span
                                x-text="timer.seconds"
                                class="font-mono font-semibold">{{ $component->seconds() }}</span> <span>seconds</span></span>
                    </x-countdown>
                </div>
            @endif


        </div>

    @endif

    <div class="flex-0 mt-6 flex justify-center">
        <div class="w-full flex justify-center">
            @auth
                @if (isset($payLink))
                    <div class="w-full">
                        <div id="loading" class="w-full flex items-center justify-center my-4">
                            <svg class="spin w-8 h-8 opacity-75" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="spinner-third" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M478.71 364.58zm-22 6.11l-27.83-15.9a15.92 15.92 0 0 1-6.94-19.2A184 184 0 1 1 256 72c5.89 0 11.71.29 17.46.83-.74-.07-1.48-.15-2.23-.21-8.49-.69-15.23-7.31-15.23-15.83v-32a16 16 0 0 1 15.34-16C266.24 8.46 261.18 8 256 8 119 8 8 119 8 256s111 248 248 248c98 0 182.42-56.95 222.71-139.42-4.13 7.86-14.23 10.55-22 6.11z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M271.23 72.62c-8.49-.69-15.23-7.31-15.23-15.83V24.73c0-9.11 7.67-16.78 16.77-16.17C401.92 17.18 504 124.67 504 256a246 246 0 0 1-25 108.24c-4 8.17-14.37 11-22.26 6.45l-27.84-15.9c-7.41-4.23-9.83-13.35-6.2-21.07A182.53 182.53 0 0 0 440 256c0-96.49-74.27-175.63-168.77-183.38z"></path></g></svg>
                        </div>
                        <div class="bg-white overflow-hidden">
                            <div id="prices" class="hidden border-t border-gray-lighter px-4 py-5 sm:p-0">
                                <dl class="divide-y divide-gray-lighter">
                                    <div class="py-2 sm:py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-dark">
                                            Subtotal
                                        </dt>
                                        <dd class="mt-1 text-sm text-right text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if($purchasable->hasActiveDiscount())
                                                <span class="mr-2">
                                                    <span class="font-semibold line-through">{{ $priceWithoutDiscount->formattedPrice() }}</span>
                                                </span>
                                            @endif
                                            <span id="subtotal" class="text-blue"></span>
                                        </dd>
                                    </div>
                                    <div class="py-2 sm:py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-dark">
                                            VAT
                                        </dt>
                                        <dd class="mt-1 text-sm text-right text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span id="tax" class="text-blue"></span>
                                        </dd>
                                    </div>
                                    <div class="py-2 sm:py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-dark">
                                            Total
                                        </dt>
                                        <dd class="mt-1 text-sm text-right text-gray-900 sm:mt-0 sm:col-span-2">
                                            <span id="total" class="text-blue"></span>
                                        </dd>
                                    </div>
                                </dl>
                                <p class="text-xs text-gray border-t border-gray-lighter pt-1">Prices in <span class="currency"></span></p>
                            </div>
                        </div>
                        <div class="checkout-container w-full"></div>
                    </div>
                    <script type="text/javascript">
                        Paddle.Setup({
                            vendor: {{ config('cashier.vendor_id') }},
                            eventCallback: function (eventData) {
                                updatePrices(eventData);
                            }
                        });
                        Paddle.Checkout.open({
                            override: '{{ $payLink }}',
                            method: 'inline',
                            product: {{ $purchasable->paddle_product_id }},
                            disableLogout: true,
                            email: '{{ auth()->user()->email }}',
                            frameTarget: 'checkout-container',
                            frameInitialHeight: 0,
                            frameStyle: 'width:100%; min-width:100%; background-color: transparent; border: none;'
                        });

                        function updatePrices(data) {
                            document.getElementById('loading').classList.add('hidden');

                            var currencyLabels = document.querySelectorAll(".currency");
                            var subtotal = data.eventData.checkout.prices.customer.total - data.eventData.checkout.prices.customer.total_tax;

                            for (var i = 0; i < currencyLabels.length; i++) {
                                currencyLabels[i].innerHTML = data.eventData.checkout.prices.customer.currency + " ";
                            }

                            const formatter = new Intl.NumberFormat('en', { style: 'currency', currency: data.eventData.checkout.prices.customer.currency });

                            document.getElementById("subtotal").innerHTML = formatter.format(subtotal.toFixed(2));
                            document.getElementById("tax").innerHTML = formatter.format(data.eventData.checkout.prices.customer.total_tax);
                            document.getElementById("total").innerHTML = formatter.format(data.eventData.checkout.prices.customer.total);

                            document.getElementById('prices').classList.remove('hidden');
                        }
                    </script>
                @else
                    <a href="{{ route('products.buy', [$product, $purchasable]) }}">
                        <x-button :large="true">
                            <span class="font-normal">Buy for&nbsp;</span>
                            <span>{{ $price->formattedPrice() }}</span>
                        </x-button>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}?next={{ route('products.buy', [$product, $purchasable]) }}">
                    <x-button :large="true">
                        <span class="font-normal">Buy for&nbsp;</span>
                        <span>{{ $price->formattedPrice() }}</span>
                    </x-button>
                </a>
            @endauth
        </div>
    </div>
</div>
