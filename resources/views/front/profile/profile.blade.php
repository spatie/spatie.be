<x-page
        title="Profile"
        background="/backgrounds/home.jpg"
>

    <div class="wrap flex">
        @include('front.profile.partials.sidebar')

        <div class="my-6 ml-4 space-y-6">
            <h1 class="mb-6 text-xl">My profile</h1>

            @if (auth()->user()->github_id)
                GitHub: {{ auth()->user()->github_username }}
                <a class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" href="{{ route('github-disconnect') }}">Disconnect</a>
            @else
                <a class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" href="{{ route('github-login') }}">Link to Github account</a>
                <p>This way we can detect your sponsor status, and you won’t need a password anymore to login</p>
            @endif

            <div class="flex items-end">
                <form class="space-y-6" action="{{ route('profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid">
                        <label for="name">Your name</label>
                        <input class="form-input" type="text" name="name" id="name" value="{{ auth()->user()->name }}">
                    </div>

                    <div class="grid">
                        <label for="email">Your email</label>
                        <input class="form-input" type="email" name="email" id="email" value="{{ auth()->user()->email }}">
                    </div>

                    <div>
                        <label for="newsletter">
                            <!-- @TODO: Check Mailcoach if user is subscribed -->
                            <input class="form-checkbox" type="checkbox" name="newsletter" id="newsletter">
                            Keep me in the loop when there is new Spatie content
                        </label>
                    </div>

                    <button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Save</button>
                </form>

                <form class="text-right mb-3" action="{{ route('profile') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="text-red text-sm" type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete my account</button>
                </form>
            </div>
        </div>
    </div>
</x-page>
