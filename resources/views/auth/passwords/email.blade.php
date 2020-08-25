<x-page
        title="Reset password"
        background="/backgrounds/auth.jpg"
>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Can't get in?
            </h1>
            <p class="banner-intro">
                Don't worry, we know the bouncer.
            </p>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('login')}}" class="link-underline link-blue">{{ __('Back to login') }}</a>
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white">
            <h2 class="title mb-8">
                {{ __('Reset Password') }}
            </h2>

                @if (session('status'))
                <div class="text-lg mb-8" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="flex">
                    <input id="email" placeholder={{ __('E-Mail Address') }} type="email" class="flex-grow mr-2 form-input @error('email') border-pink @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <x-button type="submit">
                        {{ __('Send Password Reset Link') }}
                    </x-button>
                </div>
                
                @error('email')
                    <p class="my-8 text-pink-dark text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </form>
        </div>
    </section>
</x-page>
