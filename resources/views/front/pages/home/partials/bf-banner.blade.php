@php
    use Carbon\Carbon;
    $image = image("/backgrounds/bf-25-hero-no-lines.jpg");
@endphp

@props([
    'button' => true,
    'showBackground' => true
])

@php
    $expirationDate = Carbon::createFromFormat('Y-m-d H:i', config('black-friday.expiration_date'));
@endphp

<section id="banner" class="banner" role="banner">

    @if ($showBackground)
        <div class="wallpaper banner-wallpaper bg-bf-dark">
            <img src="../images/black-friday/bf-25-scanlines.png" alt="" srcset="" class="absolute h-full z-10 mix-blend-overlay opacity-50">

            <canvas class="absolute w-full h-full inset-0 js-asteroids z-[9] opacity-50"></canvas>

            <img srcset="{{ $image->getSrcset() }}" src="{{ $image->getUrl() }}" width="2400" sizes="100vw" alt="" class="aspect-[2/3] md:h-full object-cover">
            <img src="../images/black-friday/bf-25-hero-grid.svg" alt="" srcset="" class="absolute bottom-0 max-h-[480px] object-cover object-top">
        </div>
    @endif

    <div class="flex flex-col items-center pb-12 px-4">
        <img class="w-full max-w-[800px] mb-8" src="../images/black-friday/bf-25-logo.webp" alt="">
        <h1 class="text-xl lg:text-4xl/snug text-white font-sans uppercase text-center">
            <p class="font-bold tracking-wide">30% off all Spatie products</p>
            <p>
                <x-countdown class="inline-flex gap-3 font-mono" :expires="$expirationDate">
                    <div><span x-text="timer.days">{{ $component->days() }}</span><span>d</span></div>
                    <div><span x-text="timer.hours">{{ $component->hours() }}</span><span>h</span></div>
                    <div><span x-text="timer.minutes">{{ $component->minutes() }}</span><span>m</span></div>
                    <div><span x-text="timer.seconds">{{ $component->seconds() }}</span><span>s</span></div>
                </x-countdown>
            </p>
        </h1>
    </div>

    @if ($button)
        <div class="flex flex-col items-center">
            <a href="{{ route('products.index') }}"
               class="inline-flex gap-2 justify-center text-2xl text-black font-bold transition transition-color font-pt px-8 py-4 bg-white rounded-full hover:bg-gray-lighter">
                See all deals
                <span class="icon fill-current text-current">
                    {{ app_svg('icons/far-angle-right') }}
                </span>
            </a>
        </div>
    @endif

    <div class="h-24"></div>

</section>
