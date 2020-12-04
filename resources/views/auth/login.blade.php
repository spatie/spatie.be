<x-page
    title="Log in"
    background="/backgrounds/auth.jpg"
>
    <x-slot name="description">
        Log in or create a Spatie account to get access to your Spatie products and
        licences.
    </x-slot>

    @push('scripts')
        <script>
            function showGitHubAuthWindow() {
                const authWindow = window.open(
                    '{{ route('github-login') }}',
                    null,
                    'location=0,status=0,width=800,height=400'
                );

                const authCheckInterval = window.setInterval(() => {
                    if (authWindow.closed) {
                        window.clearInterval(authCheckInterval);
                        window.location.replace('{{ session('next', route('products.index')) }}');
                    }
                }, 500);
            }
        </script>
    @endpush

    <section class="wrap pt-0 z-10 mt-6 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white md:flex items-stretch">
            <div class="flex-grow w-full">
                <h2 class="title mb-8">
                    Log in
                </h2>
                <h3 class="title-sm mb-4">
                    Via GitHub
                </h3>
                <a href="{{ route('github-login') }}" onclick="event.preventDefault(); showGitHubAuthWindow()">
                    <x-button>
                        <span class="mr-3 icon w-6 opacity">
                            {{ svg('github') }}
                        </span>
                        Log in with GitHub
                    </x-button>
                </a>

                <h3 class="mt-12 title-sm -mb-2">
                    With Email
                </h3>

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
                            <a class="ml-4 link-white link-underline text-sm" tabindex="3" href="{{ route('forgot-password') }}">
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

                    <x-button>Log in</x-button>
                </form>
            </div>

            <div class="my-8 flex items-center | md:flex-col md:my-0 md:mx-16">
                <span class="flex-grow w-1/2 h-2px bg-white bg-opacity-25 | md:w-2px md:h-1/2"></span>
                <span class="text-white text-xl text-opacity-50 mx-6 my-2">OR</span>
                <span class="flex-grow w-1/2 h-2px bg-white bg-opacity-25 | md:w-2px md:h-1/2"></span>
            </div>

            <div>
                <h2 class="title mb-8">
                    Create an account
                </h2>
                <p>No GitHub profile or Spatie account yet?</p>
                <p class="mt-4">
                    <a class="" href="{{ route('register') }}">
                        <x-button>Create an account</x-button>
                    </a>
                </p>
                <p class="mt-4">
                    A Spatie account gives you access to our free videos and to all
                    purchased products and licenses.
                </p>
            </div>

        </div>
    </section>
</x-page>
