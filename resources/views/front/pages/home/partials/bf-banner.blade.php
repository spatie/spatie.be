@php use Carbon\Carbon; @endphp
@props([
    'button' => true,
])

@php
    $expirationDate = Carbon::createFromFormat('Y-m-d H:i', config('black-friday.expiration_date'));
@endphp

<section id="banner" class="banner" role="banner">

    <div class="flex flex-col items-center pb-12 px-4">
        <img class="w-full max-w-[800px] mb-8" src="../images/black-friday/bf-25-logo.webp" alt="">
        <h1 class="text-xl lg:text-4xl/snug text-white font-sans uppercase text-center">
            <p class="font-bold tracking-wide">30% off all Spatie products</p>
            <p>
                <x-countdown class="inline-flex gap-3 font-mono" :expires="$expirationDate">
                    <div><span x-text="timer.days">{{ $component->days() }}</span><span>d</span></div>
                    <div><span x-text="timer.hours">{{ $component->hours() }}</span><span>h</span></div>
                    <div><span x-text="timer.minutes d">{{ $component->minutes() }}</span><span>m</span></div>
                    <div><span x-text="timer.seconds">{{ $component->seconds() }}</span><span>s</span></div>
                </x-countdown>
            </p>
        </h1>
    </div>

    @if ($button)
        <div class="flex flex-col items-center">
            <a href="{{ route('products.index') }}"
               class="text-lg text-black font-bold transition transition-color font-pt px-6 py-2 bg-white rounded-full hover:bg-gray-lighter">
                See all deals
            </a>
        </div>
    @endif

    <div class="h-12 hidden lg:block"></div>

</section>
