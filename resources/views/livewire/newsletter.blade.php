<aside class="wrapper-lg sm:wrapper-inset-lg md:mb-16">
    <div class="px-12 py-8 lg:px-16 lg:py-12 bg-oss-green-pale rounded-lg grid md:grid-cols-[2fr,3fr] gap-8 items-center">
        <div>
            <header class="text-oss-royal-blue font-bold text-[64px] leading-[90%] uppercase font-druk">
                Get the latest from Spatie
            </header>
            <div class="mt-6 flex items-center gap-2 sm:max-w-[50%] md:max-w-full">
                <svg class="size-9 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 36 37"><g clip-path="url(#clip0_724_4187)"><path fill="#142D6F" d="M24 .5H12C5.371.5 0 5.872 0 12.5v12c0 6.628 5.372 12 12 12h12c6.628 0 12-5.372 12-12v-12c0-6.628-5.372-12-12-12Z"/><path fill="#fff" d="M12.65 19.99h-.008c-.984 0-1.905.38-2.593 1.068a3.64 3.64 0 0 0-1.069 2.596c0 .986.38 1.907 1.07 2.596a3.64 3.64 0 0 0 2.595 1.069c.986 0 1.907-.38 2.596-1.07l.031-.03a3.681 3.681 0 0 0-.03-5.158 3.66 3.66 0 0 0-2.591-1.075v.003Zm1.548 5.153-.031.031c-.401.4-.94.623-1.52.623a2.126 2.126 0 0 1-2.144-2.143c0-.58.223-1.12.623-1.52.401-.401.94-.623 1.52-.623.58.003 1.12.226 1.522.627.4.4.623.94.623 1.516 0 .576-.21 1.091-.592 1.49h-.001Zm11.752-4.08a3.663 3.663 0 0 0-2.59-1.074h-.01c-.983 0-1.905.381-2.592 1.069a3.64 3.64 0 0 0-1.069 2.596c0 .986.38 1.907 1.069 2.596a3.64 3.64 0 0 0 2.596 1.069c.986 0 1.891-.373 2.579-1.052h.001l.016-.017a3.646 3.646 0 0 0 1.068-2.598c0-.985-.38-1.9-1.071-2.591l.003.001Zm-1.075 4.111c-.4.402-.94.624-1.52.624a2.126 2.126 0 0 1-2.143-2.143 2.125 2.125 0 0 1 2.142-2.143 2.15 2.15 0 0 1 1.52.629c.402.402.624.94.624 1.514a2.14 2.14 0 0 1-.623 1.52Zm-.412-7.25.116-1.021.521-4.617.294-2.605-2.407 1.037L18 12.862l-4.986-2.144-2.408-1.037.294 2.605.522 4.617.115 1.02.99.275a11.183 11.183 0 0 1 4.455 2.46l1.018.918 1.018-.917a11.155 11.155 0 0 1 4.455-2.461l.99-.275ZM18 19.527a12.661 12.661 0 0 0-5.065-2.797l-.522-4.617L18 14.517l5.587-2.403-.521 4.617a12.657 12.657 0 0 0-5.067 2.797H18Z"/></g><defs><clipPath id="clip0_724_4187"><path fill="#fff" d="M0 .5h36v36H0z"/></clipPath></defs></svg>
                <p class="text-sm leading-tight text-[#142D6F]">
                    Powered by <a class="underline" href="https://mailcoach.app">Mailcoach</a>, powerful email marketing tools to effortlessly
                    grow, connect and convert.
                </p>
            </div>
        </div>
        <div>
            @if($submitted)
                <div class="leading-snug">
                    <h2 class="font-semibold">Thank you for subscribing!</h2>
                    <p class="text-oss-royal-blue">You'll receive a confirmation email shortly.</p>
                </div>
            @else
                <div class="bg-white/80 py-4 px-6 rounded-md w-full flex justify-between items-center">
                    <div class="flex-1">
                        <input class="bg-transparent w-full h-full placeholder-oss-royal-blue-light" name="email" wire:model="email" type="email" placeholder="Your email address">
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
            <p class="mt-3 text-oss-royal-blue-light text-sm leading-tight">
                Sign up for occasional emails on Spatie products and promotions.
                By submitting this from, you acknowledge our <a class="underline" href="{{ route('legal.privacy') }}">Privacy Policy</a>.
            </p>
        </div>
    </div>
</aside>
