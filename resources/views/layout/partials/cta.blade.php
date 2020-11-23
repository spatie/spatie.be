@php
$expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2020-11-27 23:59' );
@endphp

<a href="{{ route('products.index') }}" class="block text-center gradient gradient-dark text-white py-2 px-6 text-sm">
        <strong>Get 30% off on all our products</strong> in the next
        <x-countdown class="inline-block" :expires="$expirationDate">
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
        – Use coupon <code class="markup-code bg-black text-xs">BLACKWEEK</code> during checkout
</a>

@once
    @push('scripts')
        <script src="/alpine/alpine.js" defer></script>
    @endpush
@endonce