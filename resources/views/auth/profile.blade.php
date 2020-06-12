<x-page
        title="Profile"
        background="/backgrounds/home.jpg"
>
    <div class="wrap">
        <h1>My profile</h1>

        @if (auth()->user()->github_id)
            GitHub: {{ auth()->user()->github_username }}
            <a href="{{ route('github-disconnect') }}">Disconnect</a>
        @else
            <a href="{{ route('github-login') }}">Link to Github account</a>
            <p>This way we can detect your sponsor status, and you won’t need a password anymore to login</p>
        @endif

        <form action="{{ route('profile') }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Your name</label>
                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}">
            </div>

            <div>
                <label for="email">Your email</label>
                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}">
            </div>

            <div>
                <label for="newsletter">
                    <!-- @TODO: Check Mailcoach if user is subscribed -->
                    <input type="checkbox" name="newsletter" id="newsletter">
                    Keep me in the loop when there is new Spatie content
                </label>
            </div>

            <button type="submit">Save</button>
        </form>

        <form action="{{ route('profile') }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete my account</button>
        </form>
    </div>
</x-page>
