@props(['title'])

<div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
    <div class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16">
        <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-10">{{ $title }}</h1>

        <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
            @include('front.profile.partials.subnav')

            <div class="flex-grow min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
