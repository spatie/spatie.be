<x-page
        title="Login"
        background="/backgrounds/home.jpg"
>
    <div class="wrap my-6 space-y-6">
        <p>Copy rond voordelen van een Spatie account…</p>

        <div class="grid gap-4">
            <h2>Log in with Github</h2>
            <a class="mr-auto bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" href="{{ route('github-login') }}">Jump to Github</a>
        </div>

        <h2>Log in with email <a class="text-blue text-xs" href="{{ route('register') }}">No account yet? Create one first</a></h2>

        <form class="space-y-6" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="grid">
                <label for="email">Your email</label>
                <input class="form-input" tabindex="1" type="email" name="email" id="email">
            </div>

            <div class="grid">
                <label for="password">Password <a class="text-blue text-xs" tabindex="3" href="{{ route('forgot-password') }}">Can't recall, send me a link</a></label>
                <input class="form-input" tabindex="2" type="password" name="password" id="password">
            </div>

            <button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Log in</button>
        </form>
    </div>
</x-page>
