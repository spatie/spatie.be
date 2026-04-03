@if($submitted)
    <div class="leading-snug">
        <h2 class="font-semibold">Thank you for subscribing!</h2>
        <p class="text-oss-royal-blue">You'll receive a confirmation email shortly.</p>
    </div>
@else
    @if($inline ?? false)
        <div class="w-full space-y-2.5 text-base">
            <div class="flex-1">
                <input class="bg-transparent w-full border border-white/10 py-2.5 px-3.5 placeholder-oss-gray-dark rounded-lg" name="email" wire:model="email" type="email" placeholder="Email address" autocomplete="email">
                @error('email')
                    <p class="mt-1 text-oss-red text-xs">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-oss-green-pale w-full py-2.5 px-3.5 text-center text-oss-gray-extra-dark rounded-lg" wire:click="subscribe">
                <span>Subscribe</span>
            </button>
        </div>
    @else
        <div class="bg-white/80 py-3 sm:py-4 px-4 sm:px-6 rounded-md w-full flex justify-between items-center text-base">
            <div class="flex-1">
                <input class="bg-transparent w-full h-full placeholder-oss-royal-blue-light" name="email" wire:model="email" type="email" placeholder="Your email address" autocomplete="email">
                @error('email')
                    <p class="text-oss-red text-xs">{{ $message }}</p>
                @enderror
            </div>

            <button class="flex items-center gap-1 text-oss-spatie-blue hover:text-oss-royal-blue underline text-base underline-offset-2 " wire:click="subscribe">
                <svg class="size-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 19"><path fill="#197593" d="m12.686 9.5-.53.53-4.5 4.5-.532.532L6.063 14l.53-.53 3.97-3.97-3.968-3.97L6.063 5l1.061-1.062.53.53 4.5 4.5.532.532Z"/></svg>
                <span>Subscribe</span>
            </button>
        </div>
    @endif
@endif
