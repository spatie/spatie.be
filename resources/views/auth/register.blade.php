<x-page
    title="Create account"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#50E69B',
        'color2' => '#2EC4B6',
        'color3' => '#197593',
        'rotationZ' => '300',
        'positionX' => '-0.7',
        'positionY' => '0.5',
        'uDensity' => '1.2',
        'uFrequency' => '5.5',
        'uStrength' => '3.2',
    ])

    @push('head')
        <script data-navigate-track src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endpush

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 mt-8 sm:mt-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-6">Join the club</h1>
            <p class="text-xl text-oss-gray-dark mb-2">Get access to videos, products and licenses.</p>
            <p>
                <a href="{{ route('login') }}" class="underline text-oss-gray-dark hover:text-white">Already have an account? Log in</a>
            </p>
        </section>

        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-12">
            <h2 class="font-bold text-2xl mb-8">Create your account</h2>

            <form action="{{ route('register') }}" class="space-y-6 max-w-[640px]" method="POST">
                @csrf

                <x-field>
                    <x-label for="name">Name</x-label>
                    <input class="form-input bg-white/10 border-white/20 text-white rounded-lg" type="text" name="name" id="name" required>
                    @error('name')
                    <div class="text-oss-red">{{ $message }}</div>
                    @enderror
                </x-field>

                <x-field>
                    <x-label for="email">Your email</x-label>
                    <input class="form-input bg-white/10 border-white/20 text-white rounded-lg" type="email" name="email" id="email" required>
                    @error('email')
                    <div class="text-oss-red">{{ $message }}</div>
                    @enderror
                </x-field>

                <div class="grid gap-6 md:grid-cols-2">
                    <x-field>
                        <x-label for="password">Choose password</x-label>
                        <input class="form-input bg-white/10 border-white/20 text-white rounded-lg" type="password" name="password" id="password" required>
                        @error('password')
                        <div class="text-oss-red">{{ $message }}</div>
                        @enderror
                    </x-field>

                    <x-field>
                        <x-label for="password_confirmation">Confirm password</x-label>
                        <input class="form-input bg-white/10 border-white/20 text-white rounded-lg" type="password" name="password_confirmation" id="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="text-oss-red">{{ $message }}</div>
                        @enderror
                    </x-field>
                </div>

                <x-field>
                    <label for="newsletter" class="flex items-center">
                        <input class="form-checkbox mr-4" type="checkbox" name="newsletter" id="newsletter">
                        Keep me in the loop when there is new Spatie content
                    </label>
                </x-field>

                <x-field>
                    <div class="cf-turnstile" data-sitekey="0x4AAAAAAA74l4-VOOV7FQJO"></div>
                    @error('cf-turnstile-response')
                    <div class="text-oss-red">{{ $message }}</div>
                    @enderror
                </x-field>

                <button class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                    Create account
                </button>
            </form>
        </section>
    </div>
</x-page>
