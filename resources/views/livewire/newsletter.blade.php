<aside>
    <header class="bg-oss-green-pale">
        Get the latest from Spatie
    </header>
    <div class="flex gap-2">
        {{-- @todo Mailcoach logo --}}
        <div class="w-6 h-6 bg-blue-darker"></div>
        <div>Powered by <a href="https://mailcoach.app">Mailcoach</a>, powerful email marketing tools to effortlessly
            grow, connect and convert.
        </div>
    </div>

    @if($submitted)
        <div>
            <div>
                <h2>Thank you for subscribing!</h2>
                <p>You'll receive a confirmation email shortly.</p>
            </div>
        </div>
    @else
        <div>
            <div>
                <div>
                    <input name="email" wire:model="email" type="email" placeholder="Your email address">
                    @error('email')
                        <div>{{ $message }}</div>
                    @enderror

                    <button wire:click="subscribe">Subscribe</button>
                </div>
            </div>
            <div>
                Sign up for occasional emails on Spatie products and promotions.
                By submitting this from, you acknowledge our <a href="{{ route('legal.privacy') }}">Privacy Policy</a>.
            </div>
        </div>
    @endif
</aside>
