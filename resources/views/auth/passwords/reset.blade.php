<x-page
    title="Reset password"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    @include('layout.partials.gradient-background', [
        'color1' => '#2EC4B6',
        'color2' => '#735AFF',
        'color3' => '#50E69B',
        'rotationZ' => '270',
        'positionX' => '0',
        'positionY' => '0',
        'uDensity' => '2.0',
        'uFrequency' => '3.5',
        'uStrength' => '2.0',
    ])

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 mt-8 sm:mt-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <h1 class="font-druk uppercase text-[50px] sm:text-[72px] leading-[0.9] font-bold mb-6">{{ __('Reset Password') }}</h1>
            <p>
                <a href="{{ route('login') }}" class="underline text-oss-gray-dark hover:text-white">Back to login</a>
            </p>
        </section>

        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0 mt-12">
            <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] p-7 md:py-12 md:px-12 max-w-[640px]">
                <form class="space-y-6" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? request('token') }}">

                    <x-field>
                        <x-label for="email">{{ __('E-Mail Address') }}</x-label>
                        <input id="email" type="email" class="form-input bg-white/10 border-white/20 text-white rounded-lg w-full"
                               @if($email) readonly="readonly" @endif name="email" value="{{ $email ?? old('email') }}"
                               required autocomplete="email" autofocus>
                        @error('email')
                        <p class="text-oss-red text-sm">{{ $message }}</p>
                        @enderror
                    </x-field>

                    <x-field>
                        <x-label for="password">{{ __('Password') }}</x-label>
                        <input id="password" type="password" class="form-input bg-white/10 border-white/20 text-white rounded-lg w-full"
                               name="password" required autocomplete="new-password">
                        @error('password')
                        <p class="text-oss-red text-sm">{{ $message }}</p>
                        @enderror
                    </x-field>

                    <x-field>
                        <x-label for="password-confirm">{{ __('Confirm Password') }}</x-label>
                        <input id="password-confirm" type="password" class="form-input bg-white/10 border-white/20 text-white rounded-lg w-full"
                               name="password_confirmation" required autocomplete="new-password">
                    </x-field>

                    <button class="inline-flex items-center gap-2 px-6 py-3 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer" type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-page>
