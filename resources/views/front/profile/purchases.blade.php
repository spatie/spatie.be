<x-page
    title="Purchases"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#735AFF',
        'color2' => '#197593',
        'color3' => '#2EC4B6',
        'rotationZ' => '200',
        'positionX' => '0.8',
        'positionY' => '0.2',
        'uDensity' => '1.5',
        'uFrequency' => '4.5',
        'uStrength' => '2.8',
    ])

    <x-profile-layout title="Purchases">
        <section class="mb-12">
            @if (!$courses->count() && !$applications->count())
                <p class="text-xl">No purchases yet, take a look at <a class="underline hover:text-white" href="{{ route('products.index') }}">our products</a>.</p>
            @else
                <p class="text-xl">Here you'll find all your purchased applications and courses.</p>
            @endif
        </section>

                @if(session()->has('sold_purchasable'))
                    @php
                        $purchasable = session()->get('sold_purchasable');
                        $assignment = session()->get('latest_assignment');
                    @endphp
                    <section class="mb-12">
                        <div class="bg-oss-green-pale text-oss-royal-blue rounded-[20px] p-7 md:py-12 md:px-12 flex flex-col md:flex-row md:items-center gap-8">
                            <h2 class="font-druk uppercase text-[40px] leading-[0.9]">Thank you!</h2>
                            <div class="text-lg">
                                <p>
                                    Thanks for buying <strong>{{ $purchasable instanceof \App\Domain\Shop\Models\Bundle ? $purchasable->title : $purchasable->product->title }}</strong>.
                                    You can view details and manage your purchase below.
                                </p>
                                @if ($assignment?->purchase?->unlocksRayLicense())
                                    <p class="mt-2">Your purchase also unlocked <a class="font-bold underline" href="#ray">a license for Ray</a>!</p>
                                @endif
                                <p class="mt-2">Here's a little bonus: you will get a <strong>10% discount</strong> on purchases in the next 24 hours!</p>
                                @if ($purchasable->getting_started_url)
                                    <p class="mt-2"><a class="underline font-bold" href="{{ $purchasable->getting_started_url }}">Get started</a> right away!</p>
                                @endif
                            </div>
                        </div>
                    </section>
                @endif

                <section>
                    @if(count($applications))
                        <h2 class="font-druk uppercase text-[40px] leading-[0.9] mb-8">Applications</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            @foreach ($applications as $product_id => $assignments)
                                @php($assignment = $assignments->sortByDesc('created_at')->first())
                                <x-purchase-assignment :assignment="$assignment" :showImage="false">
                                    @if ($assignment->purchasable->getting_started_url)
                                        <div class="px-6 py-4 border-t border-white/10">
                                            <a class="inline-flex items-center gap-2 px-5 py-2.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity text-sm"
                                               href="{{ $assignment->purchasable->getting_started_url }}">
                                                Getting started
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        @php($licenses = $assignments->flatMap(function (\App\Domain\Shop\Models\PurchaseAssignment $applicationAssignment) {
                                            return $applicationAssignment->licenses->map(function (\App\Domain\Shop\Models\License $license) use ($applicationAssignment) {
                                                $license->setRelation('assignment', $applicationAssignment);
                                                return $license;
                                            });
                                        }))
                                        <div class="w-full text-xs">
                                            @foreach ($licenses as $license)
                                                <div class="px-6 py-4 border-t border-white/10">
                                                    <div class="w-full">
                                                        <div class="font-bold uppercase tracking-wide mb-2 flex items-center justify-between text-oss-gray">
                                                            {{ $license->assignment->purchasable->title }}
                                                            <div class="font-normal normal-case text-xs {{ $license->isExpired() ? 'text-oss-red' : 'text-oss-gray-dark' }}">
                                                                @if ($license->isLifetime())
                                                                    Lifetime
                                                                @else
                                                                    {{ $license->isExpired() ? 'Expired on' : 'Expires on' }} {{ $license->expires_at->format('Y-m-d') }}
                                                                    @if ($license->assignment->purchasable->renewalPurchasable)
                                                                        <a class="underline hover:text-white ml-1"
                                                                           href="{{ route('products.buy', [$license->assignment->purchasable->product, $license->assignment->purchasable->renewalPurchasable, $license]) }}">
                                                                            {{ $license->isExpired() ? 'Renew' : 'Extend' }}
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="pb-4">
                                                            <code class="w-full flex items-center justify-between font-mono text-xs text-oss-green-pale bg-white/[0.07] px-3 py-2 rounded-lg" title="{{ $license->key }}">
                                                                <span class="break-all">{{ $license->key }}</span>
                                                                <button type="button" class="break-normal text-xs text-center select-none cursor-pointer ml-2 hover:text-white" onclick="copyLicense(this, '{{ $license->key }}')">
                                                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M352 96V0H152a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24V96z" opacity="0.4"/><path d="M96 392V96H24a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-40H152a56.06 56.06 0 0 1-56-56zM441 73L375 7a24 24 0 0 0-17-7h-6v96h96v-6.06A24 24 0 0 0 441 73z"/></svg>
                                                                </button>
                                                            </code>
                                                            <form x-data @submit.prevent="if (confirm('Are you sure you want to regenerate this license key?')) $el.submit()" class="mt-2" action="{{ route('regenerate-key', $license) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="underline text-oss-gray-dark hover:text-white">Regenerate key</button>
                                                            </form>
                                                        </div>

                                                        <div class="w-full">
                                                            @if ($license->supportsActivations())
                                                                <livewire:activations :license="$license"/>
                                                            @else
                                                                <div class="font-bold uppercase tracking-wide mb-1">Domain</div>
                                                                <livewire:domain :license="$license"/>
                                                            @endif
                                                        </div>

                                                        @if($license->isExpired() && count($license->assignment->purchasable->satis_packages ?? []))
                                                            <div class="mt-4 text-oss-gray-dark">
                                                                Your license has expired, but you can still download the latest version that was available on the expiration date.
                                                                @foreach($license->assignment->purchasable->satis_packages as $repo)
                                                                    <div class="mt-2">
                                                                        <a class="underline hover:text-white" href="{{ route('downloadLatestRelease', [$license, Str::after($repo, 'spatie/')]) }}">Download {{ $repo }} zip</a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="px-6 flex justify-between items-center text-xs py-4 border-t border-white/10">
                                            <span class="uppercase text-oss-gray-dark"><strong class="text-oss-gray">{{ $licenses->count() }}</strong> {{ \Illuminate\Support\Str::plural('license', $licenses->count()) }} added</span>
                                            <a class="underline hover:text-white" href="{{ route('products.show', $assignments->first()->purchasable->product) }}">Add new license</a>
                                        </div>
                                    </div>
                                </x-purchase-assignment>
                            @endforeach
                        </div>
                    @endif

                    @if(count($courses))
                        <h2 class="font-druk uppercase text-[40px] leading-[0.9] mt-16 mb-8">Courses</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            @foreach ($courses as $course)
                                <x-purchase-assignment :assignment="$course">
                                    <div class="max-w-full mt-4 items-center grid gap-y-4 md:gap-4 px-4 md:px-6">
                                        @foreach ($course->purchasable->series as $series)
                                            @if($series->id !== 5)
                                            <a class="block truncate w-full text-sm inline-flex items-center gap-2 px-5 py-2.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity"
                                               href="{{ route('series.show', $series) }}">
                                                @if ($series->title !== $course->purchasable->product->title)
                                                    {{ $series->title }}
                                                @else
                                                    View course
                                                @endif
                                            </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </x-purchase-assignment>
                            @endforeach
                        </div>
                    @endif
                </section>
    </x-profile-layout>

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
