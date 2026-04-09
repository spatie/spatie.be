<x-page
        title="Legal"
        background="/backgrounds/legal-blurred.jpg"
        body-class="bg-oss-gray"
        main-class="font-pt text-oss-royal-blue font-medium text-18 leading-140 antialiased"
>
    <x-slot name="description">
        General conditions, policies & disclaimers. A lot of difficult sentences.
    </x-slot>

    <header class="wrapper-lg px-7 sm:px-16 mt-6 sm:mt-12">
        <x-headers.h1 class="text-balance">
            Legal stuff
        </x-headers.h1>
        <p class="mt-4 text-lg text-oss-royal-blue-light">
            Please don't sue us
        </p>
    </header>

    <section class="wrapper-lg px-7 sm:px-16 mt-8 sm:mt-12 mb-16 lg:mb-24">
        <div class="bg-white rounded-2xl p-8 sm:p-12 md:p-16">
            <div class="grid gap-12 sm:grid-cols-2">
                <div>
                    <h2 class="text-xl font-semibold text-oss-royal-blue">
                        General conditions
                    </h2>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <a href="{{ route('legal.conditions')}}" class="underline hover:no-underline">General conditions</a>
                        </li>
                        <li>
                            <a href="{{ route('legal.gdpr')}}" class="underline hover:no-underline">GDPR addendum</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-oss-royal-blue">
                        Policies & disclaimers
                    </h2>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <a href="{{ route('legal.disclaimer')}}" class="underline hover:no-underline">Disclaimer</a>
                        </li>
                        <li>
                            <a href="{{ route('legal.privacy')}}" class="underline hover:no-underline">Privacy policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-page>
