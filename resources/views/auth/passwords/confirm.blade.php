<x-page
        title="Confirm password"
        background="/backgrounds/auth.jpg"
>

     <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                {{ __('Confirm Password') }}
            </h1>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('login')}}" class="link-underline link-blue">{{ __('Back to login') }}</a>
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white">
            <form class="space-y-6" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <x-field>
                    <label for="password" class="flex items-baseline justify-between">
                        {{ __('Password') }}
                        @if (Route::has('password.request'))
                            <a class="link-white link-underline text-sm" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </label>

                    <input id="password" type="password" class="@error('password') @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <p class="my-8 text-pink text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </x-field>

                <x-button type="submit" class="">
                    {{ __('Confirm Password') }}
                </x-button>

            </form>
        </div>
    </section>
</x-page>
