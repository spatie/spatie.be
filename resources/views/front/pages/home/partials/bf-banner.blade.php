@php
    $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2024-12-02 23:59');
@endphp

<section id="banner" class="banner" role="banner">

    <div class="flex flex-col items-center pb-12 p-4">
        <img class="max-w-[560px] mb-16" src="../images/black-friday/bf-24-logo.svg" alt="">
        <div class="text-xl lg:text-3xl text-bf-beige font-sans uppercase text-center">
            <p class="font-bold">Get 30% off on all Spatie products</p>
            <p>
                <x-countdown class="inline-block" :expires="$expirationDate">
                    <span>
                        <span class="font-semibold font-mono"
                            x-text="timer.days">{{ $component->days() }}</span><span>d</span>
                    </span>
                    <span class="ml-1">
                        <span class="font-semibold font-mono"
                            x-text="timer.hours">{{ $component->hours() }}</span><span>h</span>
                    </span>
                    <span class="ml-1">
                        <span class="font-semibold font-mono"
                            x-text="timer.minutes">{{ $component->minutes() }}</span><span>m</span>
                    </span>
                    <span class="ml-1">
                        <span class="font-semibold font-mono"
                            x-text="timer.seconds">{{ $component->seconds() }}</span><span>s</span>
                    </span>
                </x-countdown>

            </p>
        </div>
    </div>

    <div class="flex flex-col items-center">
        <a href="{{ route('products.index') }}"
            class="text-lg text-black font-bold hover:bg-gray-lighter transition transition-color font-sans px-6 py-2 bg-white rounded-full">
            Grab your promotion
        </a>
    </div>

</section>
