<x-page
    title="Reset password"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#735AFF',
        'color2' => '#2EC4B6',
        'color3' => '#197593',
        'rotationZ' => '90',
        'positionX' => '0',
        'positionY' => '0.3',
        'uDensity' => '1.6',
        'uFrequency' => '4.8',
        'uStrength' => '2.4',
    ])

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 mt-8 sm:mt-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-6">Can't get in?</h1>
            <p class="text-xl mb-2">Don't worry, we know the bouncer.</p>
            <p>
                <a href="{{ route('login') }}" class="underline hover:text-white">Back to login</a>
            </p>
        </section>

        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-12">
            <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12 max-w-[640px]">
                <h2 class="font-bold text-2xl mb-8">{{ __('Reset Password') }}</h2>

                @if (session('status'))
                    <div class="text-lg mb-8" role="alert">{{ session('status') }}</div>
                @endif

                <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">{{ __('E-Mail Address') }}</label>
                        <input id="email" placeholder="you@example.com" type="email"
                               class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" name="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="w-full sm:w-auto flex items-center justify-center px-6 py-3.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                        {{ __('Send Reset Link') }}
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-page>
