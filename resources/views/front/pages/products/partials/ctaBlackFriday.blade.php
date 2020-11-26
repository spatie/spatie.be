 @php
$expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2020-12-01 00:00' );
@endphp

 <section>
        <div class="wrap">
            <div class="card gradient gradient-dark text-white">
                <div class="wrap-card grid md:grid-cols-2 md:items-center">
                    <h2 class="title-xl">
                        Black <del class="line-through">Friday</del><br>Week
                    </h2>
                    <div class="text-2xl">
                        <p>
                            Get <strong>30%</strong> off on all our products
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
        <script src="/alpine/alpine.js" defer></script>
    @endpush
@endonce
