<section id="banner" class="banner bg-trueblack mb-32" role="banner">
    <div class="wrap">
        <a href="{{ route('products.index') }}" class="block w-3/5">
            @include('front.pages.home.partials.black-friday-banner')
        </a>

        <div class="my-8">
            @php
            $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2022-11-27 00:00' );
            @endphp

            <a href="{{ route('products.index') }}"
                class="flex  bg-trueblack text-white banner-intro">
                <div class="py-2 ">
                    ⚡️ <strong>Get 30% off</strong>  on all our products
                    <br>in the next
                    <x-countdown class="inline-block" :expires="$expirationDate">
                        <span>
                            <span class="font-semibold font-mono" x-text="timer.days">{{ $component->days()
                                }}</span><span class="text-white">d</span>
                        </span>
                        <span class="ml-1">
                            <span class="font-semibold font-mono" x-text="timer.hours">{{ $component->hours()
                                }}</span><span class="text-white">h</span>
                        </span>
                        <span class="ml-1">
                            <span class="font-semibold font-mono" x-text="timer.minutes">{{ $component->minutes()
                                }}</span><span class="text-white">m</span>
                        </span>
                        <span class="ml-1">
                            <span class="font-semibold font-mono" x-text="timer.seconds">{{ $component->seconds()
                                }}</span><span class="text-white">s</span>
                        </span>
                    </x-countdown>
                </div>
            </a>
        </div>

        <a href="{{ route('products.index') }}"
            class=" text-xl text-black font-bold hover:bg-gray-lighter transition transition-color  font-sans px-4 py-2 bg-white rounded-full">
            Grab your promotion
        </a>
    </div>
</section>
