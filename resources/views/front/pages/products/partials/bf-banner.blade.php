@php
    $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2024-12-02 23:59');
@endphp

<section id="banner" class="banner mb-16" role="banner">

    <div class="flex flex-col items-center pb-12 p-4">
        <img class="w-full max-w-[800px] mb-16" src="../images/black-friday/bf-25-logo.webp" alt="">
        <div class="text-xl lg:text-2xl text-white font-sans uppercase text-center">
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

</section>
