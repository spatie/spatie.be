@php
    $isBlackFriday = config('black-friday.enabled');
@endphp

<x-page
    title="Websites & web applications in Laravel & AI"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
    footerCta
>
    <x-slot name="description">
        Spatie builds solid websites & web applications in Laravel. With AI, we focus on solutions, not boilerplate. From Antwerp, Belgium
    </x-slot>

    <x-og-image view="og-image.home" />

    @include('layout.partials.gradient-background', [
        'color1' => '#197593',
        'color2' => '#0A2540',
        'color3' => '#21B989',
        'rotationZ' => '145',
        'positionX' => '0.5',
        'positionY' => '-0.3',
        'uDensity' => '1.6',
        'uFrequency' => '4.5',
        'uStrength' => '2.5',
    ])

    @if($isBlackFriday)
        @include('front.pages.home.partials.bf-banner')
    @else
        @include('front.pages.home.partials.banner')
    @endif

    <div class="mt-16 sm:mt-20 px-3 sm:px-16 md:px-10 lg:px-16 flex flex-col gap-y-16 sm:gap-y-48">
        @include('front.pages.home.partials.portfolio')
        @include('front.pages.home.partials.web-development')
        @include('front.pages.home.partials.open-source')
    </div>

    <div class="px-3 border-t border-white/10 bg-oss-footer-dark/50 md:mt-24">
        <div class="px-7 py-12 md:py-32">
            {{-- @include('front.pages.home.partials.newsletter') --}}
            {{-- @include('front.pages.home.partials.news') --}}

            {{-- <div class="wrap">
                <div class="grid grid-cols-2">
                    <div>
                        <h2>Work with us</h2>
                        <p>you got projects, we got questions</p>
                    </div>
                </div>
            </div> --}}

            <div class="mx-auto w-full max-w-[1080px] grid md:grid-cols-[20rem_1fr] gap-x-36 gap-y-8 md:gap-y-16">
                <h2 class="md:col-start-2 font-druk uppercase text-oss-green-pale text-[40px] sm:text-[72px] leading-[0.9] text-balance">Insights from our team and products</h2>
                <div class="space-y-12">
                    <div class="space-y-6 text-lg/snug py-2 pr-2 lg:p-4">
                        <svg class="absolute top-0 right-0 w-64" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 248 248"><mask id="path-1-inside-1_home_web_2" fill="#fff"><path d="M0 0h224c13.255 0 24 10.745 24 24v224H0V0Z"/></mask><path fill="url(#paint0_linear_home_web_2)" d="M0-1h224c13.807 0 25 11.193 25 25h-2c0-12.703-10.297-23-23-23H0v-2Zm248 249H0h248ZM0 248V0v248ZM224-1c13.807 0 25 11.193 25 25v224h-2V24c0-12.703-10.297-23-23-23v-2Z" mask="url(#path-1-inside-1_home_web_2)"/><defs><linearGradient id="paint0_linear_home_web_2" x1="0" x2="197.371" y1="247.549" y2="-35.726" gradientUnits="userSpaceOnUse"><stop offset=".605" stop-opacity="0"/><stop offset="1" stop-color="#82d8af"/></linearGradient></defs></svg>
                        <h3 class="text-4xl/[0.9] font-druk uppercase text-white">Get the latest<br /> from Spatie</h3>
                        <p>Get occasional product updates, behind the scenes, and interesting links in your mailbox.</p>
                        <div class="space-y-3">
                            <livewire:newsletter-inline />
                            <p class="text-sm text-oss-gray-medium">By submitting this form, you acknowledge our <a class="underline hover:text-oss-gray-light transition-colors" href="{{ route('legal.privacy') }}">Privacy Policy</a>.</p>
                        </div>
                    </div>
                </div>
                <div>
                    @include('front.pages.home.partials.news')
                </div>
            </div>

        </div>
    </div>

</x-page>
