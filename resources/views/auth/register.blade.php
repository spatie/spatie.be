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
            <p class="text-xl mb-2">Get access to videos, products and licenses.</p>
            <p>
                <a href="{{ route('login') }}" class="underline hover:text-white">Already have an account? Log in</a>
            </p>
        </section>

        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-12">
            <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12 max-w-[640px]">
                <h2 class="font-bold text-2xl text-white mb-8">Create your account</h2>

                <form action="{{ route('register') }}" class="space-y-6" method="POST">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium mb-1.5">Name</label>
                        <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="text" name="name" id="name" autocomplete="name" required>
                        @error('name')
                        <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">Your email</label>
                        <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="email" name="email" id="email" placeholder="you@example.com" autocomplete="email" required>
                        @error('email')
                        <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium mb-1.5">Choose password</label>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password" id="password" autocomplete="new-password" required>
                            @error('password')
                            <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm password</label>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>
                            @error('password_confirmation')
                            <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="newsletter" class="flex items-center cursor-pointer">
                            <input class="form-checkbox mr-4" type="checkbox" name="newsletter" id="newsletter">
                            Keep me in the loop when there is new Spatie content
                        </label>
                    </div>

                    <div>
                        <div class="cf-turnstile" data-sitekey="0x4AAAAAAA74l4-VOOV7FQJO"></div>
                        @error('cf-turnstile-response')
                        <div class="text-oss-red text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="w-full sm:w-auto flex items-center justify-center px-6 py-3.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                        Create account
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-page>
