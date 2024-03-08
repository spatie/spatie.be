<x-page
        title="Create account"
        background="/backgrounds/auth.jpg"
>

    <section id="banner" class="banner" role="banner">
        <div class="wrap">
            <h1 class="banner-slogan">
                Join the club
            </h1>
            <p class="banner-intro">
                Get access to videos, products and licenses.
            </p>
            <p class="mt-4">
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ app_svg('icons/far-angle-left') }}</span>
                <a
                        href="{{ route('login')}}"
                        class="link-underline link-blue">{{ __('Already have an account? Log in') }}</a>
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 mb-12">
        <div class="">
            <h2 class="title mb-8">
                Create your account
            </h2>

            <form action="{{ route('register') }}" class="space-y-6" method="POST">
                @csrf

                <x-field>
                    <x-label for="name">Name</x-label>
                    <input class="form-input" type="text" name="name" id="name" required>
                    @error('name')
                    <div class="text-pink-dark">{{ $message }}</div>
                    @enderror
                </x-field>

                <x-field>
                    <x-label for="email">Your email</x-label>
                    <input class="form-input" type="email" name="email" id="email" required>
                    @error('email')
                    <div class="text-pink-dark">{{ $message }}</div>
                    @enderror
                </x-field>

                <div class="grid gap-6 | md:grid-cols-2">
                    <x-field>
                        <x-label for="password">Choose password</x-label>
                        <input class="form-input" type="password" name="password" id="password" required>
                        @error('password')
                        <div class="text-pink-dark">{{ $message }}</div>
                        @enderror
                    </x-field>

                    <x-field>
                        <x-label for="password_confirmation">Confirm password</x-label>
                        <input class="form-input" type="password" name="password_confirmation"
                               id="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="text-pink-dark">{{ $message }}</div>
                        @enderror
                    </x-field>
                </div>

                <x-field>
                    <label for="newsletter" class="flex items-center">
                        <input class="form-checkbox mr-4" type="checkbox" name="newsletter" id="newsletter">
                        Keep me in the loop when there is new Spatie content
                    </label>
                </x-field>

                <x-button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">
                    Create account
                </x-button>
            </form>
    </section>


    </div>
</x-page>
