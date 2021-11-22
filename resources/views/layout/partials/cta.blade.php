@php
    $expirationDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i', '2021-11-30 00:00' );

    function array_some(callable $callback,$arr){
        foreach($arr as $el){
            if(call_user_func($callback,$el)){
                return true;
            }
        }
        return false;
    }
@endphp

@unless(Route::is(['home', 'products.*', 'purchases.*']))
    <a href="{{ route('products.index') }}" class="flex justify-center bg-trueblack text-center text-white text-sm">
        <div class="py-2 px-6 border-b border-gray">
            <strong>Black Friday ⚡️ Get 30% off on all our products</strong> in the next
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
        </div>
    </a>

    @once
        @push('scripts')
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endpush
    @endonce

@endif
