<x-page
    title="Log in"
    body-class="bg-oss-black text-oss-gray font-medium font-pt antialiased mb-0"
    dark
>
    <x-slot name="description">
        Log in or create a Spatie account to get access to your Spatie products and
        licences.
    </x-slot>

    @include('layout.partials.gradient-background', [
        'color1' => '#2EC4B6',
        'color2' => '#0E3B5E',
        'color3' => '#50E69B',
        'rotationZ' => '160',
        'positionX' => '0.5',
        'positionY' => '-0.4',
        'uDensity' => '1.4',
        'uFrequency' => '4.2',
        'uStrength' => '2.6',
    ])

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
                        window.location.replace('{{ session('next', route('purchases')) }}');
                    }
                }, 500);
            }
        </script>
    @endpush

    <div class="px-3 sm:px-16 md:px-10 lg:px-16 mt-8 sm:mt-16 pb-20">
        <section class="w-full max-w-[1080px] mx-auto px-7 lg:px-0">
            <div class="bg-oss-purple-extra-dark shadow-oss-card rounded-[20px] md:rounded-[48px] p-7 md:py-16 md:px-12 md:grid md:grid-cols-[1fr,auto,1fr] gap-0 items-stretch">

                {{-- Left: Log in --}}
                <div class="md:pr-12">
                    <h2 class="font-druk uppercase text-[40px] leading-[0.9] mb-8">Log in</h2>

                    <a href="{{ route('github-login') }}" onclick="event.preventDefault(); showGitHubAuthWindow()"
                       class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-white text-oss-black font-bold rounded-lg hover:bg-oss-gray transition-colors text-lg">
                        <span class="w-6 h-6 fill-current">{{ app_svg('github') }}</span>
                        Log in with GitHub
                    </a>

                    <div class="flex items-center gap-4 my-8">
                        <span class="flex-grow h-px bg-white/10"></span>
                        <span class="text-oss-gray-dark text-sm uppercase tracking-wide">or with email</span>
                        <span class="flex-grow h-px bg-white/10"></span>
                    </div>

                    <form class="space-y-5" action="{{ route('login') }}" method="POST">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="email" name="email" id="email" placeholder="you@example.com" autocomplete="email" required autofocus>
                            @error('email')
                            <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-baseline justify-between mb-1.5">
                                <label for="password" class="block text-sm font-medium">Password</label>
                                <a class="text-sm text-oss-gray-dark hover:text-white underline" tabindex="3"
                                   href="{{ route('forgot-password') }}">
                                    Forgot password?
                                </a>
                            </div>
                            <input class="w-full px-4 py-3 bg-white/[0.07] border border-white/10 text-white rounded-lg placeholder-white/30 focus:border-oss-spatie-blue focus:outline-none" type="password" name="password" id="password" autocomplete="current-password" required>
                            @error('password')
                            <p class="text-oss-red text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="w-full flex items-center justify-center px-6 py-3.5 bg-oss-green-pale text-oss-royal-blue font-bold rounded-lg hover:opacity-90 transition-opacity cursor-pointer text-lg" type="submit">
                            Log in
                        </button>
                    </form>
                </div>

                {{-- Divider --}}
                <div class="hidden md:flex flex-col items-center mx-4">
                    <div class="w-px flex-grow bg-white/10"></div>
                </div>

                {{-- Right: Create account --}}
                <div class="mt-10 pt-10 border-t border-white/10 md:mt-0 md:pt-0 md:border-t-0 md:pl-12">
                    <h2 class="font-druk uppercase text-[40px] leading-[0.9] mb-6">New here?</h2>
                    <p class="text-oss-gray-dark mb-6">
                        A Spatie account gives you access to our free videos and to all
                        purchased products and licenses.
                    </p>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 px-6 py-3.5 border border-white/20 text-white font-bold rounded-lg hover:bg-white/[0.07] transition-colors">
                        Create an account
                        <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 7 12"><path d="m6.687 6-.53.53-4.5 4.5-.532.532L.063 10.5l.53-.53L4.563 6 .596 2.03.063 1.5 1.125.438l.53.53 4.5 4.5.532.532Z"/></svg>
                    </a>
                </div>

            </div>
        </section>
    </div>
</x-page>
