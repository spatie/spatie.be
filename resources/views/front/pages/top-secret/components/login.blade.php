<div class="relative p-8 bg-white shadow-bf-smooth">

    <h1 class="font-obviously-condensed text-5xl mb-8 mx-auto text-center uppercase leading-none">
        Identify yourself, Agent
    </h1>

    <div class="p-8 paper-dotted-border">
        <div class=" md:flex items-stretch">
            <div class="flex-grow w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-12">
                    <div>
                        <a href="https://spatie.be/login/github" onclick="event.preventDefault(); showGitHubAuthWindow()">
                            <x-button class="bg-bf-brown">
                                <span class="-ml-4 mr-3 icon w-5 mb-1 opacity">
                                    {{ app_svg('github') }}
                                </span>
                                Log in with GitHub
                            </x-button>
                        </a>
                    </div>
                </div>

                <form class="space-y-6" action="https://spatie.be/login?redirect={{ request()->url() }}" method="POST">
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
                            <a class="ml-4 link-underline text-sm" tabindex="3"
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

            <div class="my-4 flex items-center | md:flex-col md:my-0 md:mx-8"></div>

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

    <div class="textured-paper absolute inset-0"></div>

</div>
