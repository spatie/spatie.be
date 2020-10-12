<x-page
        title="Log in"
        background="/backgrounds/auth.jpg"
>
    <x-slot name="description">
        Log in or create a Spatie account to get access to your Spatie products and licences.
    </x-slot>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Enter the club
            </h1>
            <p class="banner-intro">
                Get access to videos, products and licenses.
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white md:flex items-stretch">
            <div>
                <h2 class="title mb-8">
                    Log in with GitHub
                </h2>
                <a href="{{ route('github-login') }}">
                    <x-button>
                        <span class="mr-3 icon w-6 opacity">
                            {{ svg('github') }}
                        </span>
                        Log in with GitHub
                    </x-button>
                </a>
            </div>
            <div class="my-8 flex items-center | md:flex-col md:my-0 md:mx-16">
                <span class="flex-grow w-1/2 h-2px bg-white bg-opacity-25 | md:w-2px md:h-1/2"></span>
                <span class="text-white text-xl text-opacity-50 mx-6 my-2">OR</span>
                <span class="flex-grow w-1/2 h-2px bg-white bg-opacity-25 | md:w-2px md:h-1/2"></span>
            </div>
            <div class="flex-grow">
                <h2 class="title mb-8">
                    Log in with email
                </h2>

                <p>
                    <a class="link-underline link-white" href="{{ route('register') }}">
                        No account yet? Create one first. It's free!
                    </a>
                </p>

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <x-field>
                        <x-label for="email">Your email</x-label>
                        <input class="form-input" autofocus type="email" name="email" id="email" required>
                        @error('email')
                        <p class="text-pink-dark text-sm">
                            {{ $message }}
                        </p>
                        @enderror
                    </x-field>

                    <x-field>
                        <div class="flex items-baseline justify-between">
                            <x-label for="password">
                                Password
                            </x-label>
                            <a class="ml-4 link-white link-underline text-sm" tabindex="3"
                               href="{{ route('forgot-password') }}">Can't recall, send me a link</a>
                        </div>
                        <input class="form-input" type="password" name="password" id="password" required>
                        @error('password')
                        <p class="text-pink-dark text-sm">
                            {{ $message }}
                        </p>
                        @enderror
                    </x-field>

                    <x-button>Log in</x-button>
                </form>
            </div>
        </div>
    </section>
</x-page>
