 @php
$expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2021-01-20 00:00' );
@endphp

 <section>
        <div class="wrap">
            <div class="card text-white bg-cover" style="background: url('/images/bannerLaraconEU.jpg')">
                <div class="wrap-card grid md:grid-cols-2 md:items-center">
                    <h2 class="title-xl">
                       Laracon EU<br>
                       promotion
                    </h2>
                    <div class="text-2xl">
                        <p>
                            Get <strong>20%</strong> off on all our products
                        </p>
                        <div class="flex items-baseline">
                            in the next
                            <div class="ml-2 font-sans font-normal" style="font-variant-numeric:tabular-nums">
                                <x-countdown :expires="$expirationDate">
                                    <span>
                                        <span class="font-semibold font-mono" x-text="timer.days">{{ $component->days() }}</span><span class="text-white">d</span>
                                    </span>
                                    <span>
                                        <span class="font-semibold font-mono" x-text="timer.hours">{{ $component->hours() }}</span><span class="text-white">h</span>
                                    </span>
                                    <span>
                                        <span class="font-semibold font-mono" x-text="timer.minutes">{{ $component->minutes() }}</span><span class="text-white">m</span>
                                    </span>
                                    <span>
                                        <span class="font-semibold font-mono" x-text="timer.seconds">{{ $component->seconds() }}</span><span class="text-white">s</span>
                                    </span>
                                </x-countdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@once
    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
@endonce
