<x-page
        title="Reset password"
        background="/backgrounds/home.jpg"
>
    <div class="wrap">
        @if (session('status'))
            <div class="" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="">
            {{ __('Reset Password') }}
        </div>

        <form class="" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="">
                <label for="email" class="">
                    {{ __('E-Mail Address') }}:
                </label>

                <input id="email" type="email" class="@error('email')@enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <p class="">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="">
                <button type="submit" class="">
                    {{ __('Send Password Reset Link') }}
                </button>

                <p class="">
                    <a class="" href="{{ route('login') }}">
                        {{ __('Back to login') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-page>
