<x-page
    title="Testing Laravel"
    background="/backgrounds/event-sourcing.jpg"
    description="Testing Laravel"
>
    <section id="banner" class="banner" role="banner">
        <div class="wrap max-w-lg">
            <h1 class="banner-slogan">
                Testing Laravel applications
            </h1>
            <p class="banner-intro">
                A premium video course coming September 2021
            </p>
        </div>
    </section>

    <section class="pb-16">
        <div class="wrap max-w-lg markup links-underline links-blue">

        @if(session()->has('subscribed'))

        <div class="card gradient gradient-green text-white">
            <div class="wrap-card grid md:grid-cols-2 md:items-center">
                <h2 class="title-xl">
                    Thank you!
                </h2>
                <p class="text-xl">
                    Thank you for subscribing. We'll keep you in the loop!
                </p>
            </div>
        </div>

            @else
                <h2 class="title-sm">Keep me informed</h2>
                <form class="flex items-end" method="POST">
                    @csrf
                    <div class="flex-grow mr-px">
                        <input class="w-full form-input" placeholder="Email" type="email" name="email" id="email" value="{{ optional(auth()->user())->email }}">
                        @error('email')
                        <div class="text-pink-dark">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-button type="submit">Submit</x-button>
                </form>
                <p class="mt-2 text-sm text-gray">
                    Expect maximum 3 mails about this course in the next few months.
                </p>

            @endif

            <p class="mt-12 text-lg">
                Knowing how to write automated tests is a fundamental skill for any developer. By adding a quality test suite to your application you'll end up with <b>less bugs</b> in production. It allows you to <b>refactor</b> even the critical parts of your code without having to be scared.
            </p>

            <p class="text-lg">
                In this premium course, you'll learn how to test your Laravel application <b>from scratch</b>. After we've covered the basics, we'll show you <b>how we test our Laravel apps</b> at Spatie. We'll cover snapshot testing, pragmatic mocks,  testing domain code, setting up CI and much more. We'll also walk you through the <b>tests of real-world applications</b>.
                <br>

            </p>

            <p class="text-lg">
                PHPUnit is currently the de-facto standard test runner in the PHP / Laravel world. Recently, an alternative test runner, called PEST, was introduced with a focus on improving DX. We think that adoption of PEST will grow in the future. That's why you'll get <b>two flavours of the entire course</b>: in one we'll focus on <b>PHPUnit</b>, in the other we'll focus on <b>PEST</b>. We'll also show you how to convert a PHPUnit testsuite to Pest.
            </p>

            <span>
                Created by the team that brought you:
            <ul>
                <li><a href="https://laravel-beyond-crud.com">Laravel Beyond CRUD</a></li>
                <li><a href="https://event-sourcing-laravel">Event Sourcing in Laravel</a></li>
                <li><a href="https://front-line-php.com">Front Line PHP</a></li>
                <li><a href="https://laravelpackage.training">Laravel Package Training</a></li>
            </ul>
            </span>


        </div>
    </section>
</x-page>
