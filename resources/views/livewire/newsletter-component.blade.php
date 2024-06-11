<div>
    <div>
        Get the latest from Spatie
    </div>

    <div>
        <div>Logo</div>
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
</div>
