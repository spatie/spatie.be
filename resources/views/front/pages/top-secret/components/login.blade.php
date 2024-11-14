<div class="card py-12 bg-white shadow-lg">
    <h1 class="title text-3xl mb-6 mx-auto text-center uppercase text-bf-brown text-balance max-w-xl">
        Looks like you need to be logged in to access this document.
    </h1>
    <div class=" md:flex items-stretch">
        <div class="flex-grow w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-12">
                <div>
                    <a href="{{ route('github-login') }}" onclick="event.preventDefault(); showGitHubAuthWindow()">
                        <x-button class="bg-bf-brown">
                            <span class="-ml-4 mr-3 icon w-5 mb-1 opacity">
                                {{ app_svg('github') }}
                            </span>
                            Log in with GitHub
                        </x-button>
                    </a>
                </div>
            </div>

            <form class="space-y-6" action="{{ route('login') }}?redirect={{ request()->url() }}" method="POST">
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
                           href="{{ route('forgot-password') }}">
                            Can't recall, send me a link
                        </a>
                    </div>
                    <input class="form-input" type="password" name="password" id="password" required>
                    @error('password')
                    <p class="text-pink-dark text-sm">
                        {{ $message }}
                    </p>
                    @enderror
                </x-field>

                <x-button class="bg-bf-brown">Log in</x-button>
            </form>
        </div>

        <div class="my-8 flex items-center | md:flex-col md:my-0 md:mx-16">
            <span class="flex-grow w-1/2 h-2px bg-white/25 | md:w-2px md:h-1/2"></span>
            <span class="text-xl text-opacity-50 mx-6 my-2">OR</span>
            <span class="flex-grow w-1/2 h-2px bg-white bg-opacity-25 | md:w-2px md:h-1/2"></span>
        </div>

        <div class="h-full my-auto">
            <p>No GitHub profile or Spatie account yet?</p>
            <p class="mt-4">
                <a class="" href="{{ route('register') }}">
                    <x-button class="bg-bf-brown">Create an account</x-button>
                </a>
            </p>
            <p class="mt-4">
                A Spatie account gives you access to our free videos and to all
                purchased products and licenses.
            </p>
        </div>

    </div>
</div>
