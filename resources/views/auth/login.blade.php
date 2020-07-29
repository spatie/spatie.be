<x-page
        title="Login"
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

    <section class="section pt-0">
        <div class="wrap sm:flex items-stretch">
            <div class="">
                <h2 class="title-sm mb-8">
                    Log in with Github
                </h2>
                <a class="mr-auto bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" href="{{ route('github-login') }}">
                    Jump to Github
                </a>
            </div>
            <div class="my-8 flex items-center | sm:flex-col sm:my-0 sm:mx-16">
                <span class="flex-grow w-1/2 h-2px bg-gray-light bg-opacity-50 | sm:w-2px sm:h-1/2"></span>
                <span class="text-gray mx-6 my-2">OR</span>
                <span class="flex-grow w-1/2 h-2px bg-gray-light bg-opacity-50 | sm:w-2px sm:h-1/2"></span>
            </div>
            <div class="flex-grow">
                <h2 class="title-sm mb-8">
                    Log in with email 
                </h2>

                <p>
                    <a class="link-underline link-blue" href="{{ route('register') }}">
                        No account yet? Create one first
                    </a>
                </p>

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="grid">
                        <label for="email">Your email</label>
                        <input class="form-input" tabindex="1" type="email" name="email" id="email">
                    </div>

                    <div class="grid">
                        <label for="password" class="flex items-baseline">
                            Password 
                            <a class="ml-4 link-blue link-underline text-xs" tabindex="3" href="{{ route('forgot-password') }}">Can't recall, send me a link</a></label>
                        <input class="form-input" tabindex="2" type="password" name="password" id="password">
                    </div>

                    <button class="bg-blue hover:bg-blue-dark text-white px-5 py-2 rounded-sm text-sm" type="submit">Log in</button>
                </form>
            </div>
        </div>
    </section>
</x-page>
