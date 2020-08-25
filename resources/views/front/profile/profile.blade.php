<x-page
        title="Profile"
        background="/backgrounds/auth.jpg"
>

    @include('front.profile.partials.subnav')

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                My profile
            </h1>
            <div class="mt-4">
                @if (auth()->user()->github_id)
                    <span class="flex items-center">
                        <span class="icon fill-current w-4 mr-2">
                            {{ svg('github') }}
                        </span>
                        <span class="font-bold">{{ auth()->user()->github_username }}</span>
                        <a class="ml-4 link-blue link-underline" href="{{ route('github-disconnect') }}">Disconnect from GitHub</a>
                    </span>
                @else
                    <a class="link-blue link-underline flex items-center" href="{{ route('github-login') }}">
                        <span class="icon fill-current w-4 mr-2">
                            {{ svg('github') }}
                        </span>
                        Connect to GitHub account
                    </a>
                    <p class="mt-1 text-sm text-gray">Log in without password and check your sponsor status.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="section section-group pt-0">
        @include('front.profile.partials.sponsor')
        
        <div class="wrap">
            <form class="space-y-6" action="{{ route('profile') }}" method="POST">
                @csrf
                @method('PUT')

                <x-field>
                    <x-label for="name">Your name</x-label>
                    <input class="form-input" type="text" name="name" id="name" value="{{ auth()->user()->name }}">
                </x-field>

                <x-field>
                    <x-label for="email">Your email</x-label>
                    <input class="form-input" type="email" name="email" id="email" value="{{ auth()->user()->email }}">
                </x-field>

                <x-field>
                    <label for="newsletter">
                        <!-- @TODO: Check Mailcoach if user is subscribed -->
                        <input class="form-checkbox mr-4" type="checkbox" name="newsletter" id="newsletter" {{ auth()->user()->isSubscribedToNewsletter() ? 'checked' : ''}}>
                        Keep me in the loop when there is new Spatie content
                    </label>
                </x-field>

                <x-button type="submit">Save profile</x-button>
            </form>

            <form class="absolute bottom-0 right-0 pr-8 | sm:pr-16" action="{{ route('profile') }}" method="POST">
                @csrf
                @method('DELETE')

                <button class="link-underline link-red" type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete my account</button>
            </form>
        </div>
    <section>
</x-page>
