@props(['title'])

<div class="px-3 sm:px-16 md:px-10 lg:px-16 pb-20">
    <div class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-8 sm:mt-16">
        <div class="flex flex-col md:flex-row gap-8 md:gap-12">
            <div class="order-2 md:order-1 w-full md:w-[220px] flex-shrink-0">
                <div class="hidden md:block" style="height: 105px;"></div>
                <div class="md:sticky md:top-8">
                    @include('front.profile.partials.subnav')
                </div>
            </div>

            <div class="order-1 md:order-2 flex-grow min-w-0">
                <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-10">{{ $title }}</h1>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
