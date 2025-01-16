<x-page
    title="Purchases"
    background="/backgrounds/auth.jpg"
>
    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Purchases
            </h1>
            @if (!$courses->count() && !$applications->count())
                <p class="banner-intro">No purchases yet, take a look at <a class="link-underline link-blue"
                                                                            href="{{ route('products.index') }}">our
                        products</a>.</p>
            @else
                <p class="banner-intro">Here you'll find all your purchased applications and courses.</p>
            @endif
        </div>
    </section>

    @if(session()->has('sold_purchasable'))
        @php
            /** @var \App\Domain\Shop\Models\Purchasable $purchasable */
            $purchasable = session()->get('sold_purchasable');

            /** @var \App\Domain\Shop\Models\PurchaseAssignment $assignment */
            $assignment = session()->get('latest_assignment');
        @endphp

        <section id="cta" class="pb-16">
            <div class="wrap">
                <div class="card gradient gradient-green text-white">
                    <div class="wrap-card grid md:grid-cols-2 md:items-center">
                        <h2 class="title-xl">
                            Thank you!
                        </h2>
                        <p class="text-xl">
                            Thanks for buying
                            <strong>{{ $purchasable instanceof \App\Domain\Shop\Models\Bundle ? $purchasable->title : $purchasable->product->title }}</strong>.
                            You can view details and manage your purchase below this page.

                            @if ($assignment)
                                <br/><br/>
                                @if($assignment->purchase?->unlocksRayLicense())
                                    Your purchase also unlocked <a class="font-bold underline" href="#ray">a license for
                                        Ray</a>!
                                    <br/><br/>
                                @endif
                            @endif

                            Here's a little bonus: you will get a <strong>10% discount</strong> on purchases in the next
                            24 hours!
                            @if ($purchasable->getting_started_url)
                                <br/><br/>
                                <a class="link-white link-underline" href="{{ $purchasable->getting_started_url }}">Get
                                    started</a> right away!
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section section-group pt-0">
        <div class="wrap max-w-md md:max-w-columns">
            @if(count($applications))
                <h2 class="title line-after mb-12">Applications</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    @foreach ($applications as $product_id => $assignments)
                        @php($assignment = $assignments->sortByDesc('created_at')->first())
                        <x-purchase-assignment :assignment="$assignment" :showImage="false" theme="white">
                            <div class="items-center grid gap-4 bg-gray-50 px-6 py-6">
                                {!! $assignment->purchasable->getting_started_description !!}
                                @if ($assignment->purchasable->getting_started_url)
                                    <a class="block w-full text-xs md:text-base"
                                       href="{{ $assignment->purchasable->getting_started_url }}">
                                        <x-button> Getting started
                                        </x-button>
                                    </a>
                                @endif
                            </div>
                            <div class="">
                                @php($licenses = $assignments->flatMap(function (\App\Domain\Shop\Models\PurchaseAssignment $applicationAssignment) {
                                    return $applicationAssignment->licenses->map(function (\App\Domain\Shop\Models\License $license) use ($applicationAssignment) {
                                        $license->setRelation('assignment', $applicationAssignment);
                                        return $license;
                                    });
                                }))
                                <div class="">
                                    <div class="">
                                        <div class="w-full text-xs">
                                            @foreach ($licenses as $license)
                                                <div
                                                    class="px-6 py-4 border-b border-gray-lighter py-4 {{ $loop->even ? 'bg-blue-50' : '' }}">
                                                    <div class="flex flex-wrap justify-between">
                                                        <div class="w-full">
                                                            <div
                                                                class="font-bold uppercase tracking-wide mb-2 flex items-center justify-between">
                                                                {{ $license->assignment->purchasable->title }}
                                                                <div
                                                                    class="font-normal normal-case text-xs {{ $license->isExpired() ? 'text-pink-dark' : '' }}">
                                                                    @if ($license->isLifetime())
                                                                        Lifetime
                                                                    @else
                                                                        {{ $license->isExpired() ? 'Expired on' : 'Expires on' }} {{ $license->expires_at->format('Y-m-d') }}
                                                                        @if ($license->assignment->purchasable->renewalPurchasable)
                                                                            <a class="link-black link-underline"
                                                                               href="{{ route('products.buy', [$license->assignment->purchasable->product, $license->assignment->purchasable->renewalPurchasable, $license]) }}">
                                                                                {{ $license->isExpired() ? 'Renew this license' : 'Extend license' }}
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="pb-4">
                                                                <code
                                                                    class="w-full flex items-center justify-between font-mono text-xs text-blue {{ $loop->even ? 'bg-gray-lighter' : 'bg-blue-lightest' }} bg-opacity-25 px-2 py-2 rounded-sm"
                                                                    title="{{ $license->key }}"
                                                                >
                                                                    <span class="break-all">{{ $license->key }}</span>
                                                                    <span
                                                                        class="break-normal text-xs right-0 text-center underline select-none cursor-pointer"
                                                                        onclick="copyLicense(this, '{{ $license->key }}')"><svg
                                                                            aria-hidden="true" focusable="false"
                                                                            data-prefix="fad" data-icon="copy"
                                                                            class="w-4 h-4 fill-current" role="img"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 448 512"><g class="fa-group"><path
                                                                                    class="fa-secondary"
                                                                                    fill="currentColor"
                                                                                    d="M352 96V0H152a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24V96z"
                                                                                    opacity="0.4"></path><path
                                                                                    class="fa-primary"
                                                                                    fill="currentColor"
                                                                                    d="M96 392V96H24a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-40H152a56.06 56.06 0 0 1-56-56zM441 73L375 7a24 24 0 0 0-17-7h-6v96h96v-6.06A24 24 0 0 0 441 73z"></path></g></svg></span></code>
                                                                <form
                                                                    x-data
                                                                    @submit.prevent="if (confirm('Are you sure you want to regenerate this license key?')) $el.submit()"
                                                                    class="mt-2"
                                                                    action="{{ route('regenerate-key', $license) }}"
                                                                    method="POST"
                                                                >
                                                                    @csrf
                                                                    <button type="submit" class="underline">Regenerate key</button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="w-full">
                                                            @if ($license->supportsActivations())
                                                                <livewire:activations :license="$license"/>
                                                            @else
                                                                <div class="font-bold uppercase tracking-wide mb-1">
                                                                    Domain
                                                                </div>
                                                                <livewire:domain :license="$license"/>
                                                            @endif
                                                        </div>

                                                        @if($license->isExpired() && count($license->assignment->purchasable->satis_packages ?? []) )
                                                            <div class="mt-6">
                                                            Your license has expired, but you can still download the
                                                                latest version that was available on the expiration
                                                            date of your license. You are allowed to put this code in a
                                                            private repo of your own and require that in your
                                                            composer.json.

                                                            @foreach($license->assignment->purchasable->satis_packages as $repo)
                                                                <div class="mt-2">
                                                                    <a class="link-black link-underline" href="{{ route('downloadLatestRelease', [$license, Str::after($repo, 'spatie/')]) }}">Download {{ $repo }} zip</a>
                                                                </div>
                                                            @endforeach

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div
                                        class="px-6 flex justify-between items-center text-xs py-4 border-b border-gray-lighter">
                                        <span class="uppercase"><strong>{{ $licenses->count() }}</strong> {{ \Illuminate\Support\Str::plural('license', $licenses->count()) }} added</span>
                                        <a class="link-black link-underline"
                                           href="{{ route('products.show', $assignments->first()->purchasable->product) }}">Add new license</a>
                                    </div>
                                </div>
                            </div>
                        </x-purchase-assignment>
                    @endforeach
                </div>
            @endif

            @if(count($courses))
                <h2 class="title line-after mt-20 mb-12">Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-x-8 md:gap-y-12">
                    @foreach ($courses as $course)
                        <x-purchase-assignment :assignment="$course">
                            <div class="max-w-full mt-4 items-center grid gap-y-4 md:gap-4 px-4 md:px-6">
                                @foreach ($course->purchasable->series as $series)
                                    @if($series->id !== 5) {{-- do not show old laravel package course --}}
                                    <a class="block truncate w-full text-xs md:text-base"
                                       href="{{ route('series.show', $series) }}">
                                        <x-button
                                            >
                                            @if ($series->title !== $course->purchasable->product->title)
                                                {{ $series->title }}
                                            @else
                                                View course
                                            @endif
                                        </x-button>
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </x-purchase-assignment>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script type="text/javascript">
            function copyLicense(element, licenseKey) {
                navigator.clipboard.writeText(licenseKey).then(function () {
                    element.classList.add('text-green');

                    setTimeout(() => {
                        element.classList.remove('text-green');
                    }, 2000);
                });
            }
        </script>
    @endpush
</x-page>
