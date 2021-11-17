<section id="banner" class="banner bg-trueblack" role="banner">
    <div class="wrap">
        <div class=" w-3/5">
            @include('front.pages.home.partials.black-friday-banner')
        </div>


        <div class="my-8">
            @php
            $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2021-12-01 00:00' );

            @endphp

            <a href="{{ route('products.index') }}"
                class="flex  bg-trueblack text-white text-sm">
                <div class="py-2 ">
                    <strong>⚡️ Get 30% off on all our products</strong> in the next
                    <x-countdown class="block" :expires="$expirationDate">
                        <span>
                            <span class="font-semibold text-3xl font-mono" x-text="timer.days">{{ $component->days()
                                }}</span><span class="text-white">d</span>
                        </span>
                        <span>
                            <span class="font-semibold text-3xl font-mono" x-text="timer.hours">{{ $component->hours()
                                }}</span><span class="text-white">h</span>
                        </span>
                        <span>
                            <span class="font-semibold text-3xl font-mono" x-text="timer.minutes">{{ $component->minutes()
                                }}</span><span class="text-white">m</span>
                        </span>
                        <span>
                            <span class="font-semibold text-3xl font-mono" x-text="timer.seconds">{{ $component->seconds()
                                }}</span><span class="text-white">s</span>
                        </span>
                    </x-countdown>
                </div>
            </a>

            @once
            @push('scripts')
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
            @endpush
            @endonce

        </div>

        <a href="{{ route('products.index') }}"
            class=" text-black font-bold hover:bg-gray-lighter transition transition-color  font-sans px-4 py-2 bg-white rounded-full">
            Grab your promotion
        </a>

        <div class="absolute right-8 bottom-0  hidden md:flex">

            <div class="bg-white absolute right-0 animate-slidein rounded-full w-32 h-32 inline-block   ">
                <p
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 rotate text-7xl  font-black text-gray-darkest ">
                    %</p>
            </div>
            <div
                class="bg-white rounded-full w-32 animate-fadein1 h-32 inline-block transform scale-x-75 scale-y-90 translate-x-28   opacity-75">
                <p
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-7xl  font-black text-gray-darkest ">
                    %</p>
            </div>
            <div
                class="bg-white rounded-full w-32 h-32 animate-fadein2 inline-block transform scale-x-50 scale-y-105  translate-x-28 opacity-50">
                <p
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-7xl  font-black text-gray-darkest ">
                    %</p>
            </div>
            <div
                class="bg-white rounded-full w-32 h-32 animate-fadein3 inline-block transform scale-x-25 scale-y-120 translate-x-18 opacity-25 ">
                <p
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-7xl  font-black text-gray-darkest ">
                    %</p>
            </div>
            <div
                class="bg-white rounded-full w-32 h-32 animate-fadein4 inline-block transform scale-x-15 scale-y-145 opacity-5">
                <p
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-7xl  font-black text-gray-darkest ">
                    %</p>
            </div>


        </div>
    </div>
</section>