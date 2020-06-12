<x-page
        title="Login"
        background="/backgrounds/home.jpg"
>
    <div class="wrap">
        <p>Copy rond voordelen van een Spatie account…</p>

        <h2>Log in with Github</h2>
        <a href="{{ route('github-login') }}">Jump to Github</a>

        <h2>Log in with email</h2>
        <a href="{{ route('register') }}">No account yet? Create one first</a>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div>
                <label for="email">Your email</label>
                <input type="email" name="email" id="email">
            </div>

            <div>
                <label for="password">Password <a href="{{ route('forgot-password') }}">Can't recall, send me a link</a></label>
                <input type="password" name="password" id="password">
            </div>

            <button type="submit">Log in</button>
        </form>
    </div>
</x-page>
