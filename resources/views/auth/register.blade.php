<x-page
        title="Register"
        background="/backgrounds/home.jpg"
>
    <div class="wrap my-6">
        <h2 class="text-xl">Create account <a class="text-blue text-xs" href="{{ route('login') }}">Already have an account? Log in</a></h2>

        <form action="{{ route('register') }}" class="space-y-6" method="POST">
            @csrf

            <div class="grid">
                <label for="name">Name</label>
                <input class="form-input" type="text" name="name" id="name" required>
                @error('name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">
                <label for="email">Your email</label>
                <input class="form-input" type="email" name="email" id="email" required>
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">
                <label for="password">Choose password</label>
                <input class="form-input" type="password" name="password" id="password" required>
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">
                <label for="password_confirmation">Confirm password</label>
                <input class="form-input" type="password" name="password_confirmation" id="password_confirmation" required>
                @error('password_confirmation')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">
                <label for="newsletter">
                    <input class="form-checkbox" type="checkbox" name="newsletter" id="newsletter">
                    Keep me in the loop when there is new Spatie content
                </label>
            </div>

            <button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Create account</button>
        </form>
    </div>
</x-page>
