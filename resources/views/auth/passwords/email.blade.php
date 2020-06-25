<x-page
        title="Reset password"
        background="/backgrounds/home.jpg"
>
    <div class="wrap my-6">
        @if (session('status'))
            <div class="" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="text-xl">
            {{ __('Reset Password') }}
        </h1>

        <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="grid">
                <label for="email" class="">
                    {{ __('E-Mail Address') }}:
                </label>

                <input id="email" type="email" class="form-input @error('email') border-red @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <p class="">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex space-x-4 items-center">
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm">
                    {{ __('Send Password Reset Link') }}
                </button>

                <a class="text-blue" href="{{ route('login') }}">
                    {{ __('Back to login') }}
                </a>
            </div>
        </form>
    </div>
</x-page>
