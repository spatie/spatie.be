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
                <span class="icon mr-2 opacity-50 fill-current text-blue">{{ svg('icons/far-angle-left') }}</span> <a
                        href="{{ route('login')}}" class="link-underline link-blue">{{ __('Already have an account? Log in') }}</a>
            </p>
        </div>
    </section>

    <section class="wrap pt-0 z-10 -mb-6">
        <div class="card py-12 gradient gradient-green shadow-lg text-white">
            <h2 class="title mb-8">
                Create your account
            </h2>
            
            <form action="{{ route('register') }}" class="space-y-6" method="POST">
            @csrf

            <x-field>
                <label for="name">Name</label>
                <input class="form-input" type="text" name="name" id="name" required>
                @error('name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </x-field>

            <x-field>
                <label for="email">Your email</label>
                <input class="form-input" type="email" name="email" id="email" required>
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </x-field>

            <x-field>
                <label for="password">Choose password</label>
                <input class="form-input" type="password" name="password" id="password" required>
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </x-field>

            <x-field>
                <label for="password_confirmation">Confirm password</label>
                <input class="form-input" type="password" name="password_confirmation" id="password_confirmation" required>
                @error('password_confirmation')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </x-field>

            <x-field>
                <label for="newsletter" class="flex items-center">
                    <input class="form-checkbox mr-4" type="checkbox" name="newsletter" id="newsletter">
                    Keep me in the loop when there is new Spatie content
                </label>
            </x-field>

            <x-button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Create account</x-button>
        </form>
        </section>

        
    </div>
</x-page>
