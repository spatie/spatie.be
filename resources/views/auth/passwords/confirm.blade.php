<x-page
        title="Confirm password"
        background="/backgrounds/home.jpg"
>
    <h1>
        {{ __('Confirm Password') }}
    </h1>

    <form class="" method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <p class="">
            {{ __('Please confirm your password before continuing.') }}
        </p>

        <div class="">
            <label for="password" class="">
                {{ __('Password') }}:
            </label>

            <input id="password" type="password" class="@error('password') @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <p class="">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="">
            <button type="submit" class="">
                {{ __('Confirm Password') }}
            </button>

            @if (Route::has('password.request'))
                <a class="" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
</x-page>
