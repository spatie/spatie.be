<x-page
        title="Reset password"
        background="/backgrounds/auth.jpg"
>

     <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ __('Reset Password') }}
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('login')}}" class="link-underline link-blue">{{ __('Back to login') }}</a>
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white">
           <form class="space-y-6" method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token ?? request('token') }}">

                        <x-field>
                            <x-label for="email">
                                {{ __('E-Mail Address') }}:
                            </x-label>

                            <input id="email" type="email" class="form-input w-full @error('email') border-pink @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <p class="my-8 text-pink-dark text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </x-field>

                        <x-field>
                            <x-label for="password">
                                {{ __('Password') }}:
                            </x-label>

                            <input id="password" type="password" class="form-input w-full @error('password') border-pink @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <p class="my-8 text-pink-dark text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </x-field>

                        <x-field>
                            <x-label for="password-confirm">
                                {{ __('Confirm Password') }}:
                            </x-label>

                            <input id="password-confirm" type="password" class="form-input w-full" name="password_confirmation" required autocomplete="new-password">
                        </x-field>

                        <x-button type="submit">
                            {{ __('Reset Password') }}
                        </x-button>
                    </form>
        </div>
    </section>

</x-page>
